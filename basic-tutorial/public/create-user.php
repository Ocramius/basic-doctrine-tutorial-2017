<?php

// creating a new user:

// 1. check if the current user can actually create users (RBAC)
// 2. check if user already exists: if so, fail
// 3. create a new user
// 4. activate the user
// 5. send password reset email to the user
// 6. save the user

// Tip: discuss - email or saving? Chicken-egg problem
