<? // -*- html -*-
   // $Id$
   require_once("docutil.php");
   page_head("Operational Tools");
?>

BOINC provides tools for creating and operating projects:
<table border=1 width=100%>
  <tr><td><code>boinc/sched/</code></td><td> <a href=tool_start.php><code>start</code></a> </td> <td>
      BOINC start / Super Cron program
  </td></tr>
  <tr><td><code>boinc/tools/</code></td><td> <a href=tool_add.php><code>add</code></a> </td> <td>
      Adds objects to the database.
  </td></tr>
  <tr><td><code>boinc/tools/</code></td><td> <a href=single_host_server.php><code>make_project</code></a> </td> <td>
      Creates a project
  </td></tr>
  <tr><td><code>boinc/tools/</code></td><td> <a href=tool_update_versions.php><code>update_versions</code></a> </td> <td>
      Adds all relevant core client and application executables to download
      directory and database
  </td></tr>
</table>

Projects can create their own tools using the Python API (see <a
href=python.php>Python framework</a>) or the C++ API (<code>db/db.h</code>)

<?
   page_tail();
?>

