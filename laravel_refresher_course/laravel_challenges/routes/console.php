<?php
use Illuminate\Support\Facades\Schedule;

Schedule::command('users:generate-csv')->weekly();
