<?php

// to be executed in a cronjob
// 1. find all users with overdue book return dates, then:
//     2.1. send notification to users within reasonable return overdue threshold
//     OR
//     2.2 forward enforcement request to enforcement department
//
// Bonus: make sure users are not notified more than once
