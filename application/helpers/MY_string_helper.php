<?php

function elog($msg)
{
    log_message('error', $msg);     
}

function now()
{
    return date('Y-m-d H:i:s');
}