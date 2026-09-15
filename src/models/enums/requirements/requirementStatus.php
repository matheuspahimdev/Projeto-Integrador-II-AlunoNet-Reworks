<?php

enum RequirementStatus: string
{
    case OPEN = 'OPEN';
    case IN_REVIEW = 'IN_REVIEW';
    case ANSWERED = 'ANSWERED';
    case CLOSED = 'CLOSED';
    case REJECTED = 'REJECTED';
}