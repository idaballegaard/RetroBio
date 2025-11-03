<?php
require_once __DIR__ . "/BaseController.php";
require_once __DIR__ . "/../repositories/UserRepository.php";

abstract class AdminController extends BaseController {

    function __construct() {
        UserRepository::dieIfNotAdmin();
    }

}