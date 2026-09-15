<?php

enum Role: string
{
    case STUDENT = 'STUDENT';
    case TEACHER = 'TEACHER';
    case COORDINATOR = 'COORDINATOR';
    case ADMINISTRATOR = 'ADMINISTRATOR';
}