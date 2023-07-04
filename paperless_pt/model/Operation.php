<?php

class Operation
{

    function get_operation($optgrp_id)
    {
        $get_operation = "SELECT 
        DISTINCT OPERATION_CODE,
        OPERATION_DESCRIPTION,
        ATTRIBUTE15
        FROM 
            APPS.BOM_STANDARD_OPERATIONS 
        WHERE ---OPERATION_DESCRIPTION IS NOT NULL AND 
            OPERATION_DESCRIPTION NOT LIKE '%DO NOT USE%'
            AND
            ATTRIBUTE15 = ".$optgrp_id." ";

        $dboracle = new OracleApp();

        $result = $dboracle->query($get_operation)->fetchAll();

        return $result;
    }
}