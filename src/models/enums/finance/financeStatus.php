<?php

enum FinanceStatus: string
{
    case PENDING = 'PENDING';
    case PAID = 'PAID';
    case OVERDUE = 'OVERDUE';
    case CANCELLED = 'CANCELLED';
}