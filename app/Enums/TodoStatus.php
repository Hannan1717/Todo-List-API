<?php

namespace App\Enums;

enum TodoStatus: string
{
    case TODO = 'Todo';
    case ON_PROGRESS = 'On Progress';
    case DONE = 'Done';
}
