<?php

enum ExamStatus: string
{
    case DRAFT = 'DRAFT';
    case PUBLISHED = 'PUBLISHED';
    case GRADED = 'GRADED';
    case CANCELLED = 'CANCELLED';
}