<?php
  
  // mysqL DB constants
  define("DB_HOST", 'localhost');
  define("DB_DB", 'mytaxca');
  define("DB_USER", 'root');
  define("DB_PW", '123456');

  // Search types
  define("SEARCH_TASK", 1);
  define("SEARCH_CLIENT", 2);
  define("SEARCH_DEADLINE", 3);

  // Admin constants
  define("OWNER", 3);

  // Sidebar printing
  define("DASHBOARD", 1);
  define("SEARCH", 2);
  define("NEW_TASK", 3);

  // Task types
  define('NOT_STARTED', 0);
  define('IN_PROGRESS', 1);
  define('DONE', 2);

?>