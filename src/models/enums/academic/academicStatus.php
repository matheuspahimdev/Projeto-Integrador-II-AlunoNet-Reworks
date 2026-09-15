<?php

enum AcademicStatus: string
{
    case ACTIVE = 'ACTIVE';
    case INACTIVE = 'INACTIVE';
    case PENDING = 'PENDING';
    case COMPLETED = 'COMPLETED';
    case CANCELLED = 'CANCELLED';
}