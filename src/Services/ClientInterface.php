<?php
namespace App\Services;

interface ClientInterface{

    function creer();
    function modifier();
    function consulter($id);
    function supprimer($id);

}