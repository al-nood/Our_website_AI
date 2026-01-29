<?php include "config.php";?>
<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="theme-color" content="#000" />
    <meta name="generator" content="Astro v5.13.2" />
    <title> nestoria </title>

    <link href="../css/bootstrap.min.css" rel="stylesheet" />

    <link href="css/style.css" rel="stylesheet" />

</head>

<body>
    <main class="d-flex bg-light">
        <h1 class="visually-hidden">DashBord </h1>
        <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width: 280px"><a href="/"
                class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="32" fill="currentColor"
                    class="bi bi-shield-fill-check" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.54 1.54 0 0 0-1.044 1.262c-.596 4.477.787 7.795 2.465 9.99a11.8 11.8 0 0 0 2.517 2.453c.386.273.744.482 1.048.625.28.132.581.24.829.24s.548-.108.829-.24a7 7 0 0 0 1.048-.625 11.8 11.8 0 0 0 2.517-2.453c1.678-2.195 3.061-5.513 2.465-9.99a1.54 1.54 0 0 0-1.044-1.263 63 63 0 0 0-2.887-.87C9.843.266 8.69 0 8 0m2.146 5.146a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793z" />
                </svg>
                <span class="fs-4 title"> PILOT ADMIN</span>
            </a>
            <hr />
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="#" class="nav-link active" aria-current="page">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                            class="bi bi-house-door-fill me-2" viewBox="0 0 16 16">
                            <path
                                d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5" />
                        </svg>
                        Dashboard
                    </a>

                </li>

                <li class="nav-item">
                    <a class="nav-link text-white rounded-0 collapsed" href="#authors" data-bs-toggle="collapse"
                        role="button" aria-expanded="false" aria-controls="reportsCollapse">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-person-workspace me-2" viewBox="0 0 16 16">
                            <path
                                d="M4 16s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-5.95a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5" />
                            <path
                                d="M2 1a2 2 0 0 0-2 2v9.5A1.5 1.5 0 0 0 1.5 14h.653a5.4 5.4 0 0 1 1.066-2H1V3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v9h-2.219c.554.654.89 1.373 1.066 2h.653a1.5 1.5 0 0 0 1.5-1.5V3a2 2 0 0 0-2-2z" />
                        </svg>
                        Users
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-chevron-down float-end" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708" />
                        </svg>
                    </a>

                    <div class="collapse" id="authors">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1">
                            <li>
                                <a href="show.php" class="nav-link text-white submenu-link ">
                                    Show Data
                                </a>
                            </li>
                            
                            
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white rounded-0 collapsed" href="#books" data-bs-toggle="collapse"
                        role="button" aria-expanded="false" aria-controls="reportsCollapse">
                         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                          class="bi bi-house-fill me-2" viewBox="0 0 16 16">
                         <path d="M8.707 1.5a1 1 0 0 0-1.414 0L1 7.793V14a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1V11h2v3a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1V7.793l-6.293-6.293z"/>
                         </svg> properties
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-chevron-down float-end" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708" />
                        </svg>
                    </a>

                    <div class="collapse" id="books">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1">
                            <li>
                                <a href="showproperties.php" class="nav-link text-white  submenu-link">
                                    Show Data
                                </a>
                            </li>
                            <li>
                                <a href="index.php" class="nav-link text-white  submenu-link">
                                    Add Data
                                </a>
                            </li>
                            
                        </ul>
                    </div>
                </li>
                 
                <li class="nav-item">
                    <a class="nav-link text-white rounded-0 collapsed" href="#books" data-bs-toggle="collapse"
                        role="button" aria-expanded="false" aria-controls="reportsCollapse">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-calendar-check-fill me-2" viewBox="0 0 16 16">
                        <path d="M4 .5a.5.5 0 0 1 .5.5V1h6V.5a.5.5 0 0 1 1 0V1h.5A1.5 1.5 0 0 1 13 2.5V14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V2.5A1.5 1.5 0 0 1 4.5 1H5V.5a.5.5 0 0 1 .5-.5m6.854 6.354-3.5 3.5a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 9.293l3.146-3.147a.5.5 0 0 1 .708.708"/>
                        </svg> Bookings
                       <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-chevron-down float-end" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708" />
                        </svg>
                    </a>

                    <div class="collapse" id="books">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1">
                            <li>
                                <a href="showbooking.php" class="nav-link text-white  submenu-link">
                                    Show Data
                                </a>
                            </li>
                            <li>
                                <a href="addbooking.php" class="nav-link text-white  submenu-link">
                                    Add Data
                                </a>
                            </li>
                            
                        </ul>
                    </div>
                </li>

            </ul>
            <hr />
            <?php if(isset($_SESSION['user_id'])): ?>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="images/default-user.png" alt="" width="32" height="32" class="rounded-circle me-2" />
                    <?php echo htmlspecialchars($_SESSION['uname'] ?? 'User'); ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow">

                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="admins.php">Management</a></li>
                </ul>
            </div>
            <?php endif; ?>
            <?php if(isset($_SESSION['message'])): ?>
            <div class="alert alert-<?= $_SESSION['type']; ?>">
           <?= $_SESSION['message']; ?>
           </div>
          <?php 
           unset($_SESSION['message']);
           unset($_SESSION['type']);
           endif; 
           ?>


        </div>
        <div class="b-example-divider page-container"></div>