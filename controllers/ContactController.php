<?php
require_once __DIR__ . "/BaseController.php";
require_once __DIR__ . "/../viewModels/ContactViewModel.php";
require_once __DIR__ . "/../repositories/AboutRepository.php";

class ContactController extends BaseController {
    public function showContactForm() : ContactViewModel {
      return new ContactViewModel("views/contact.php");
    }

    public function sendMail() : ContactViewModel {
        $about = (new AboutRepository())->getAboutInfo();
        $purpose = safeString($_POST['purpose'] ?? '');
        $message = safeString($_POST['message'] ?? '');
        $email = filter_var($_SESSION['email'], FILTER_SANITIZE_EMAIL) ?? '';

        $headers = 'From: ' . $email . "\r\n" .
            'Reply-To: ' . $email;

        mail($about['email'], $purpose, $message, $headers);

        $viewModel = new ContactViewModel("views/contact.php");
        $viewModel->setMailSent(true);
        return $viewModel;
    }
}