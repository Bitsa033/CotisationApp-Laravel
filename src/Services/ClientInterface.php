<?php
namespace App\Services;

interface ClientInterface{

    // function createData(array $data,$insertMethod);
    function updateData(array $data);
    function findAllData();
    function deleteOneData($id);

}