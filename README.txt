INTRODUCTION
------------

Edit Limits adds certain limits to editing nodes and comments. This can set the
number of times a node can be edit. This can also set a time frame for nodes to
be edited, as well as a different time frame that comments can be edited.

Limits on nodes can be combined, so that a node can only be edit a set number of
times or within the time frame.

Node edit count

Nodes can be limited to a certain number of edits before it is locked. This can
be restricted to a subset of content types. Users with the "bypass edit limits"
permission who edit nodes will not count against this edit count limit.

Node edit time limit

Nodes can be limited to a given time frame. When this is used, nodes can only be
edited within the time limit set by the site administrator, starting when the
node is initially saved. This can be limited to a subset of content types.

Comment edit time limit

Comments can be set to only be limited within a given time frame. Site
administrators can set the number of seconds after a comment is initially posted
before it can no longer be edited. Time remaining will be displayed to the user.


INSTALLATION
------------

Install as you would normally install a contributed Drupal module. See
https://drupal.org/documentation/install/modules-themes/modules-7
for further information.


CONFIGURATION
-----------

* Configure the module in Administration » Content Authoring » Edit Limit
(admin/config/content/edit_limit).

* Configure user permissions in Administration » People » Permissions
(admin/people/permissions):

  - Bypass edit limits

    Bypass the edit limits set in place for normal users.

  - Administer edit limits

    Bypass the edit limits set in place for normal users.


CREDITS
-------

Original development was sponsored by https://Skirt.com.
