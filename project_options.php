<?php

require_once("docutil.php");
page_head("Project options");

echo "
The following elements in the &lt;config&gt; section
of your <a href=configuration.php>config.xml</a> file
control various aspects of your project.
";
echo html_text("
    <master_url>            URL                     </master_url>
    <long_name>             name                    </long_name>
    <host>                  project.hostname.ip   </host>
    <db_name>               databasename          </db_name>
    <db_host>               database.host.ip      </db_host>
    <db_user>               database_user_name    </db_user>
    <db_passwd>             database_password     </db_passwd>
    <shmem_key>             shared_memory_key     </shmem_key>
    <download_url>          http://A/URL          </download_url>
    <download_dir>          /path/to/directory    </download_dir>
    <download_dir_alt>      /path/to/directory    </download_dir_alt>
    <uldl_dir_fanout>       N                     </uldl_dir_fanout>
    <upload_url>            http://A/URL          </upload_url>
    <upload_dir>            /path/to/directory    </upload_dir>
    <cgi_url>               http://A/URL          </cgi_url>
    <log_dir>               /path/to/directory    </log_dir>

    [ <disable_account_creation/> ]
    [ <profile_screening/> ]
    [ <show_results/> ]
    [ <one_result_per_user_per_wu/> ]
    [ <max_wus_to_send> N </max_wus_to_send> ]
    [ <non_cpu_intensive> 0|1 </non_cpu_intensive> ]
    [ <min_sendwork_interval> N </min_sendwork_interval> ]
    [ <daily_result_quota> N </daily_result_quota> ]
    [ <ignore_delay_bound/> ]
    [ <dont_generate_upload_certificates/> ]
    [ <locality_scheduling/> ]
    [ <locality_scheduling_wait_period> N </locality_scheduling_wait_period> ]
    [ <min_core_client_version> N </min_core_client_version ]
    [ <choose_download_url_by_timezone/> ]
    [ <min_core_client_version_announced> N </min_core_client_version_announced> ]
    [ <min_core_client_upgrade_deadline> N </min_core_client_upgrade_deadline> ]
    [ <choose_download_url_by_timezone> N </choose_download_url_by_timezone> ]
    [ <cache_md5_info> 0|1 </cache_md5_info> ]
    [ <nowork_skip> 0|1 </nowork_skip> ]
    [ <resend_lost_results> 0|1 </resend_lost_results> ]
    [ <sched_lockfile_dir> path </sched_lockfile_dir> ]
    [ <min_passwd_length> N </min_passwd_length> ]
    [ <fp_benchmark_weight> X </fp_benchmark_weight> ]
    [ <default_disk_max_used_gb> X </default_disk_max_used_gb> ]
    [ <default_disk_max_used_pct> X </default_disk_max_used_pct> ]
    [ <default_disk_min_free_gb> X </default_disk_min_used_pct> ]
    [ <max_claimed_credit>X</max_claimed_credit ]
    [ <grant_claimed_credit/> ]
    [ <symstore>URL</symstore> ]
    [ <dont_delete_batches/> ]
    [ <sched_debug_level> N </sched_debug_level> ]
    [ <fuh_debug_level> N </fuh_debug_level> ]
    [ <verify_files_on_app_start/> ]


    <!-- optional; defaults as indicated: -->
    <project_dir>  ../      </project_dir>  <!-- relative to location of 'start' -->
    <bin_dir>      bin      </bin_dir>      <!-- relative to project_dir -->
    <cgi_bin_dir>  cgi-bin  </cgi_dir>      <!-- relative to project_dir -->
  </config>
")
;

list_start();
list_bar("Hosts, directories, and URLs (these are created
by make_project; normally you don't need to change them)");
list_item("host",
    "name of project's main host, as given by Python's socket.hostname().
    Daemons and tasks run on this host by default."
);
list_item("db_name", "Database name");
list_item("db_host", "Database host machine");
list_item("db_user", "Database user name");
list_item("db_passwd", "Database password");
list_item("shmem_key", "ID of scheduler shared memory.  Must be unique on host.");
list_item("download_url", "URL of data server for download");
list_item("download_dir", "absolute path of download directory");
list_item("download_dir_alt",
    "absolute path of old download directory
    (see <a href=hier_dir.php>Hierarchical upload/download directories</a>)"
);
list_item("upload_url", "URL of file upload handler");
list_item("uldl_dir_fanout", "fan-out factor of upload and download directories
    (see <a href=hier_dir.php>Hierarchical upload/download directories</a>)"
);
list_item("upload_dir", "absolute path of upload directory");
list_item("cgi_url", "URL of scheduling server");
list_item("log_dir", "Path to the directory where the assimilator, feeder, transitioner and
cgi output logs are stored.  This allows you to change the default log
directory path.  If set explicitly, you can also use the 'grep logs'
features on the administrative pages.  Note: enabling 'grep logs' with
very long log files can hang your server, since grepping GB files can
take a long time.  If you enable this feature, be sure to rotate the
logs so that they are not too big.");
list_item("sched_lockfile_dir",
    "Enables scheduler locking (recommended) and specifies
    directory where scheduler lockfiles are stored.
    Must be writable to the Apache user.
");
list_bar("Web site features");
list_item("profile_screening",
    "If present, don't show profile pictures until they've been
    screened and approved by project admins."
);
list_item("show_results",
    "Enable web site features that show results (per user, host, etc.)"
);

list_bar( "Miscellaneous");
list_item("disable_account_creation",
    "If present, disallow account creation"
);
list_item("min_passwd_length",
    "Minimum length of user passwords.  Default is 6."
);

list_bar( "Client control");
list_item("verify_files_on_app_start",
    "Before starting or restarting an app,
    check contents of input files and app version files
    by either MD5 or digital signature check.
    Detects user tampering with file
    (but doesn't really increase security,
    since user could also change MD5s or signatures in
    client state file)."
);
list_item("symstore",
    "URL of your project's symbol store,
    used for debugging Windows applications."
);
list_item("min_core_client_version_announced",
     "Announce a new version of the BOINC core client, which in the future
      will be the minimum required version.  In conjunction with the next
      tag, you can warn users with version below this to upgrade by a
      specified deadline.  Example value: 419."
);
list_item("min_core_client_upgrade_deadline",
    "Use in conjunction with the previous tag.  The value given here is the
     Unix epoch returned by time(2) until which hosts can update their
     core client.  After this time, they may be shut out of the project.
     Before this time, they will receive messages warning them to upgrade."
);
list_item("non_cpu_intensive",
    "If this flag is present,
    the project will be treated specially by the client:
    <ul>
    <li> The client will download one result at a time.
    <li> This result will be executed whenever computation is enabled
        (bypassing the normal scheduling mechanism).
    </ul>
    This is intended for
    <a href=non_cpu_intensive.php>applications that use little CPU time</a>,
    e.g. that do network or host measurements."
);
list_bar( "Server logging");
list_item("sched_debug_level",
    "Verbosity level for scheduler log output.
    1=minimal, 2=normal (default), 3=verbose."
);
list_item("fuh_debug_level",
    "Verbosity level for file upload handler log output.
    1=minimal, 2=normal (default), 3=verbose."
);

list_bar( "Credit");
list_item("max_claimed_credit",
    "If a result claims more credit than this, mark it as invalid."
);
list_item("grant_claimed_credit",
    "If set, grant the claimed credit,
    regardless of what other results for this workunit claimed.
    These is useful for projects where
    different instances of the same job
    can do much different amounts of work.
    "
);
list_item("fp_benchmark_weight",
    "The weighting given to the Whetstone benchmark
    in the calculation of claimed credit.
    Must be in [0 .. 1].
    Projects whose applications are floating-point intensive should use 1;
    pure integer applications, 0.
    Choosing an appropriate value will reduce the disparity
    in claimed credit between hosts.
    The script html/ops/credit_study.php,
    run against the database of a running project,
    will suggest what value to use."
);
list_bar( "Scheduling options and parameters");
list_item("one_result_per_user_per_wu",
    "If present, send at most one result of a given workunit to a given user.
    This is useful for checking accuracy/validity of results.
    It ensures that the results for a given workunit are generated by
    <b>different</b> users.
    If you have a validator that compares different results
    for a given workunits to ensure that they are equivalent,
    you should probably enable this.
    Otherwise you may end up validating results from a given user
    with results from the <b>same</b> user."
);
list_item("max_wus_to_send",
    "Maximum results sent per scheduler RPC. Helps prevent hosts with
    trouble from getting too many results and trashing them.  But you
    should set this large enough so that a host which is only connected to
    the net at intervals has enough work to keep it occupied in between
    connections."
);
list_item("min_sendwork_interval",
    "Minimum number of seconds to wait after sending results to a given
    host, before new results are sent to the same host.  Helps prevent
    hosts with download or application problems from trashing lots of
    results by returning lots of error results.  But don't set it to be so
    long that a host goes idle after completing its work, before getting
    new work."
);
list_item("daily_result_quota",
    "Maximum number of results (per CPU) sent to a given host in a 24-hour
    period. Helps prevent hosts with download or application problems from
    returning lots of error results.  Be sure to set it large enough that
    a host does not go idle in a 24-hour period, and can download enough
    work to keep it busy if disconnected from the net for a few days. The
    maximum number of CPUS is bounded at four."
);
list_item("ignore_delay_bound",
    "By default, results are not sent to hosts too slow to complete them within delay bound.
    If this flag is set, this rule is not enforced."
);
list_item("dont_generate_upload_certificates",
    "Don't put upload certificates in results.
    This makes result generation a lot faster,
    since no encryption is done,
    but you lose protection against DoS attacks
    on your upload servers."
);
list_item("locality_scheduling",
    "When possible, send work that uses the same files that the host
     already has. This is intended for projects which have large data
     files, where many different workunits use the same data file. In
     this case, to reduce download demands on the server, it may be
     advantageous to retain the data files on the hosts, and send
     them work for the files that they already have.
     See <a href=sched_locality.php>Locality Scheduling</a>."
);
list_item("locality_scheduling_wait_period",
    "This element only has an effect when used in conjunction with the
     previous locality scheduling element. It tells the scheduler to
     use 'trigger files' to inform the project that more work is
     needed for specific files. The period is the number of seconds
     which the scheduler will wait to see if the project can create
     additional work. Together with project-specific daemons or
     scripts this can be used for 'just-in-time' workunit
     creation. See <a href=sched_locality.php>Locality Scheduling</a>."
);
list_item("min_core_client_version",
    "If the scheduler gets a request from a client with
    a version number less than this,
    it returns an error message and doesn't do any other processing."
);
list_item("choose_download_url_by_timezone",
     "When the scheduler sends work to hosts, it replaces the download
      URL appearing in the data and executable file descriptions with
      the download URL closest to the host's timezone.  The project
      must provide a two-column file called 'download_servers' in the
      project root directory.  This is a list of all download servers
      that will be inserted when work is sent to hosts.  The first column
      is an integer listing the server's offset in seconds from UTC.
      The second column is the server URL in the format such as
      http://einstein.phys.uwm.edu.  The download servers must
      have identical file hierarchies and contents, and the path to
      file and executables must start with '/download/...' as in 
      'http://einstein.phys.uwm.edu/download/123/some_file_name'."
);
list_item("cache_md5_info",
     "When creating work, keep a record (in files called foo.md5) of the
      file length and md5 sum of data files and executables.  This can
      greatly reduce the time needed to create work, if (1) these files
      are re-used, and (2) there are many of these files, and (3) reading
      the files from disk is time-consuming."
);
list_item("nowork_skip",
    "If the scheduling server has no work,
    it replies to RPCs without doing any database access
    (e.g., without looking up the user or host record).
    This reduces DB load, but it fails to update
    preferences when users click on Update.
    Use it if your server DB is overloaded."
);
list_item("resend_lost_results",
    "If set, and a &lt;other_results> list is present
    in scheduler request,
    resend any in-progress results not in the list.
    This is recommended;
    it should increase the efficiency of your project.  Note that
    in an ideal world, it would never be necessary to resend results.
    The first time that they were sent from the server, the client would
    receive them and no resending would be needed.  However it is the
    experience of several projects that, for reasons that are
    not well understood, a BOINC client sometimes fails to receive the
    scheduler reply.  This flag addresses that issue: it causes the SAME results to be RESENT
    by the scheduler, if the client has failed to receive them.
    It works as follows.  In its scheduler request, the BOINC
    client includes a list of results that it has already received.  The scheduler
    checks these against the database to be sure that the client has received
    ALL results which should be present.  If there are missing results on
    client, and this flag is set, then those results are RESENT by the
    scheduler before any new work is sent."
);

list_item("default_disk_max_used_gb", "Sets the default value for
    the disk_max_used_gb preference so its consistent between the
    scheduler and web pages.  The scheduler uses it when a request
    for work doesn't include preferences, or the preference is set
    to zero.  The web page scripts use it to set the initial value
    when displaying or editing preferences the first time, or when
    the user never saved them.  Default is 100.
");

list_item("default_disk_max_used_pct", "Sets the default value for
    the disk_max_used_pct preference so its consistent between the
    scheduler and web pages.  The scheduler uses it when a request
    for work doesn't include preferences, or the preference is set
    to zero.  The web page scripts use it to set the initial value
    when displaying or editing preferences the first time, or when
    the user never saved them. Default is 50.
");

list_item("default_disk_min_free_gb", "Sets the default value for
    the disk_min_free_gb preference so its consistent between the
    scheduler and web pages.  The scheduler uses it when a request
    for work doesn't include preferences.  The web page scripts use
    it to  set the initial value when displaying or editing 
    preferences the  first time, or when the user never saved them.
    Also, the scheduler uses this setting to override any smaller
    preference from the host, it enforces a 'minimum free disk space'
    to keep from filling up the drive.  Recommend setting this no
    smaller than .001 (1MB or 1,000,000 bytes).  Default is .001.
");
list_item("reliable_time<br> reliable_min_avg_credit<br>
    reliable_min_avg_turnaround<br> reliable_reduced_delay_bound",
    "These parameters control a mechanism that attempts to send
    old results (e.g. those whose siblings have timed out or failed)
    to fast, reliable hosts.
    <p>
    This mechanism is used when the age of a workunit exceeds
    <b>reliable_time</b> (typically 2-3X the delay bound).
    The results are sent to hosts with at least
    <b>reliable_min_avg_credit</b> and at most
    <b>reliable_max_avg_turnaround</b>.
    The delay bound is multiplied by <b>reliable_reduced_delay_bound</b>
    (typically 0.5 or so).
    "
);

list_bar( "File deleter options");
list_item("dont_delete_batches",
    "If this boolean is set,
    the file deleter won't delete any files for which
    the corresponding workunit or result record has
    a positive value of the the 'batch' field.
    This lets you keep files on disk until you're done with them.
    Create workunits with a positive batch number,
    and zero out (or negate) the batch number when you're done
    looking at the files
    (you can do this with a SQL query).
    If you use this option, replace the indices on
    file_delete_state with indices on (file_delete_state, batch)."
);

list_end();

page_tail();
?>
