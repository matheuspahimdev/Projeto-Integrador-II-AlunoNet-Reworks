<?php

enum LoanStatus: string
{
    case AVAILABLE = 'AVAILABLE';
    case BORROWED = 'BORROWED';
    case RETURNED = 'RETURNED';
    case OVERDUE = 'OVERDUE';
    case LOST = 'LOST';
}