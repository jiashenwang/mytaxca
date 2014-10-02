<?php
  
  // mysqL DB constants
  define("DB_HOST", 'localhost');
  define("DB_DB", 'mytaxca');
  define("DB_USER", 'root');
  define("DB_PW", '123456');

  // Search types
  define("SEARCH_TASK_NAME", 1);
  define("SEARCH_CLIENT_NAME", 2);
  define("SEARCH_COMPANY_NAME", 3);
  define("SEARCH_EMPLOYEE_NAME", 4);

  // Admin constants
  define("OWNER", 3);

  // Sidebar printing
  define("DASHBOARD", 1);
  define("SEARCH", 2);
  define("NEW_TASK", 3);

  // Task types + task array constants
  define('TOTAL', -1);
  define('NOT_STARTED', 0);
  define('IN_PROGRESS', 1);
  define('DONE', 2);
  

  // Task array divisor
  define('ALL', 'all');
  define('STATUS', 'status');

?>