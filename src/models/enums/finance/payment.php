<?php

enum TypePayment: string {
    case PIX = 'PIX';
    case CREDIT_CARD = 'CREDIT_CARD';
    case DEBIT_CARD = 'DEBIT_CARD';
    case TICKET = 'TICKET';
    case BANK_TRANSFER = 'BANK_TRANSFER';
}