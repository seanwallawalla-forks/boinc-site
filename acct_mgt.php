<?php
require_once("docutil.php");

page_head("Account management systems");

echo "
<p>
The 'manual' procedure for creating BOINC accounts is as follows.
A participant must:
<ul>
<li> locate BOINC project web sites,
read them, and decide which to join;
<li> Download and install the BOINC client software.
</ul>
and then for each selected project:
<ul>
<li> fill out a web registration form;
<li> handle an email;
<li> cut and paste a URL and account key into the BOINC client.
</ul>

<p>
If the participant chooses N projects,
there are N forms to fill out,
N emails to handle, and N dialog interactions with the BOINC client.
This is tedious if there are lots of projects.
Furthermore, it involves cutting and pasting long random strings,
which is intimidating to some participants.

<p>
This document describes BOINC's support for <b>account management systems</b>,
which streamline the process of finding and joining BOINC projects.
A typical account management system is implemented as a web site.
The participant experience is:
<ul>
<li> Visit the account manager site,
set up a 'meta-account' (name, email, password),
browse a list of projects, and click checkboxes to select projects.
<li> Handle an email from each selected project
(click on a link in the email).
<li> Download and install the BOINC client software from the account manager.
<li> Enter the meta-account name and password in a BOINC client dialog.
</ul>
This requires about 1/3 of the interactions of the manual approach,
and avoids dealing with long random strings.

<h2>Implementation</h2>
<p>
An account management system works as follows:
<br>
<img src=acct_mgt.png>
<br>

<ol>
<li> The participant sets up his meta-account and selects projects.
<li> The account manager issues a <b>create account</b> RPC
to each selected project.
<li> The project creates an account (marked as 'unconfirmed')
and sends an email to the participant.
<li> The participant opens the email and clicks on a link in it,
causing the account to be marked as 'confirmed'.
<li> The account manager periodically polls each selected project
with a <b>query account</b> RPC,
waiting for all accounts to become confirmed.
<li> When all accounts are confirmed,
the participant downloads and installs the BOINC client software
from the account manager.
The install package includes a file
(specific to this account manager)
containing the URL of the account manager.
<li> The BOINC client runs, and asks the participant to enter
the name and password of his meta-account.
<li> The BOINC client does a <b>query accounts</b> RPC
to the account manager, obtaining a list of accounts.
It then attaches to these accounts and proceeds.
</ol>
<p>
This architecture involves two RPC mechanisms:
<ul>
<li> <b>Account creation RPCs</b> (steps 2 and 5 above);
<li> A <b>Account manager RPCs</b> (step 8 above).
</ul>
This document describes these two RPC mechanisms.
The underlying protocol of both mechanisms is as follows:
<ul>
<li> Each RPC is an HTTP GET transaction.
<li> The input is the GET arguments, i.e. a string of the form
".html_text("
param1=val1&param2=val2&...&paramn=valn
")."
there param1 ... paramN are the parameter names,
and val1 ... valn are the values.
The outputs are XML.
</ul>

<h2>Account creation RPCs</h2>
<p>
The RPC functions are as follows:

<h3>Create account</h3>
";

list_start();
list_item("URL", "project_url/am_create.php");
list_item(
	"input",
        "email_addr: email address
		<br>nonce: nonce ID (crypto-random string)"
);
list_item(
	"output",
    html_text("<am_create_reply>
    [ <error>message</error> ]
    [ <success/>
</am_create_reply>
    ")
);
list_item(
	"action",
		"The server creates a tentative account.
		The server sends email to the given address, of the form:
        <pre>
Someone (hopefully you) joined [project name] with this email address.
To confirm your participation in [project name] please visit the following URL:
    xxx

If you do not want to participate in [project name], just ignore this message.
        </pre>
		When the participant visits xxx, the account is confirmed.
");
list_end();

echo "
<h3>Query account</h3>
";

list_start();
list_item("URL", "project_url/am_query.php");
list_item("input",
    "nonce"
);
list_item("output",
    html_text("<am_query_reply>
    [<error>MSG</error>]
    [ <success/>
    <confirmed>0</confirmed> ]
    [ <success/>
    <account_key>KEY</account_key> ]
</am_query_reply>
    ")
);
list_item("action",
    "If the account has been confirmed, returns the account key."
);
list_end();

echo "
<h3>Get account info</h3>
";

list_start();
list_item("URL", "project_url/am_get_info.php");
list_item("input", "account_key");
list_item("output",
	html_text("<am_get_info_reply>
    <name>NAME</name>
    <country>COUNTRY</country>
    <postal_code>POSTAL_CODE</postal_code>
    <global_prefs>
    GLOBAL_PREFS
    </global_prefs>
    <project_prefs>
    PROJECT_PREFS
    </project_prefs>
    <url>URL</url>
    <send_email>SEND_EMAIL</send_email>
    <show_hosts>SHOW_HOSTS</show_hosts>
</am_get_info_reply>
    ")
);
list_item("action", "returns data associated with the given account");
list_end();
echo "
<h3>Set account info</h3>
";
list_start();
list_item("URL", "project_url/am_set_info.php");
list_item("input",
    "account_key
    <br>[ name ]
    <br>[ country ]
    <br>[ postal_code ]
    <br>[ global_prefs ]
    <br>[ project_prefs ]
    <br>[ url ]
    <br>[ send_email ]
    <br>[ show_hosts ]
    "
);
list_item("output",
    html_text("<am_set_info_reply>
    [ <error>MSG</error ]
    [ <success/> ]
</am_set_info_reply>")
);
list_item("action",
    "updates one or more items of data associated with the given account"
);

list_end();

echo "
<h2>Account manager RPCs</h2>

";

list_start();
list_item("URL", "Given in the file account_manager_url.xml,
    included in the installer"
);
list_item("input", "name
    <br>password"
);
list_item("output",
    html_text("<account_manager_reply>
    [ <error>MSG</error> ]
    [ <account>
        <url>URL</url>
        <key>KEY</key>
      </account>
      ...
    ]
</account_manager_reply>")
);
list_item("action",
    "returns a list of the accounts associated with this meta-account"
);
list_end();

page_tail();
?>
