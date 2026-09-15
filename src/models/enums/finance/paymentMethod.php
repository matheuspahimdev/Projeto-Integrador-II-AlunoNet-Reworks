<?php

enum PaymentMethod: string
{
    case PIX = 'PIX';
    case CREDIT_CARD = 'CREDIT_CARD';
    case DEBIT_CARD = 'DEBIT_CARD';
    case BANK_SLIP = 'BANK_SLIP';
    case BANK_TRANSFER = 'BANK_TRANSFER';
}