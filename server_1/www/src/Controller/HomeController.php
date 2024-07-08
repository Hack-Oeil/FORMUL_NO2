<?php
 
namespace App\Controller;

use Yoop\AbstractController;
use App\Service\Wav2Mp3;

class HomeController extends AbstractController
{
    public function print() 
    {
        if(sizeof($_POST)) {
            $flag = null;
            $errors = [];
            // Les différents controle
            if($_GET['id'] == 42) $errors[] = 'Vous devez soumettre avec un id différent de 42 dans la chaine de requête.';
            if($_POST['secret'] == 8) $errors[] = 'Vous devez soumettre une valeur différente dans le champ secret.';
            if((int) $_POST['number_1'] <= 10) $errors[] = 'Vous devez soumettre une valeur supérieur à 10 dans le champ 1.';
            if(!preg_match('/[A-Za-z]/', $_POST['number_2'])) $errors[] = 'Vous devez soumettre une valeur autre que numérique le champ 2.';
            if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) || empty($_POST['email'])) $errors[] = 'Vous devez soumettre une valeur autre qu\'une adresse email dans le champ 3.';
            // Date 1
            if(empty($_POST['date_1']) || !preg_match('/[0-9]{4}-[0-9]{2}-[0-9]{2}/', $_POST['date_1']) || new \DateTime($_POST['date_1']) <= new \DateTime('2020-12-31')) {
                $errors[] = 'Vous devez soumettre une date supérieur au 2020-12-31 dans le champ 4.';
            }
            // Date 2
            if(empty($_POST['date_2']) || preg_match('/[0-9]{4}-[0-9]{2}-[0-9]{2}/', $_POST['date_2']) || empty($_POST['email'])) {
                $errors[] = 'Vous devez soumettre une valeur différente d\'une date dans le champ 5.';
            }
            if(empty($_POST['select_1']) || in_array($_POST['select_1'], ['A','B','C'])) {
                $errors[] = 'Vous devez soumettre une valeur différente que celle attendue dans le champ 6.';
            }
            if(empty($_POST['select_2']) || in_array($_POST['select_2'], ['1','2','3'])) {
                $errors[] = 'Vous devez soumettre une valeur différente que celle attendue dans le champ 7.';
            }
            if(!strpos($_POST['multi_line'],"\n")) {
                $errors[] = 'Vous devez soumettre une valeur avec au moins 1 saut de ligne dans le champ 8.';
            }
            if(!is_array($_POST['tab'])) {
                $errors[] = 'Vous devez soumettre un tableau pour le champ 9.';
            }
            if(isset($_POST['not_need'])) {
                $errors[] = 'Vous ne devez pas soumettre le champ 10.';
            }
            if(!(isset($_POST['need_empty']) && empty($_POST['need_empty']))) {
                $errors[] = 'Vous devez soumettre le champ 11, mais vide.';
            }

            if(sizeof($errors) === 0) {
                $flag = base64_decode('QmllbiBqb3XDqSBsZSBmbGFnIGVzdCA6IA').$this->getFlag();
            }
            // Traitement
            return $this->render('web/home', ['errors' => $errors, 'flag' => $flag]);
        }
        else if(isset($_GET['id']) && $_GET['id'] == 42) {
            return $this->render('web/home');
        }
        // Dans les autres cas on redirige vers le formulaire avec l'id 42
        $this->redirectToRoute("/?id=42");
    }
}
