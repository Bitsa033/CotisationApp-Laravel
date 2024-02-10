<?php
namespace App\Services;

interface ClientInterface{

    function createData(array $data);
    function updateData(array $data);
    function findAllData($id);
    function deleteOneData($id);

}