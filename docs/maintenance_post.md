# StatusPage Update Tool - Maintenance Post

## When should I make this post?

Maintenance Posts are for any type of update/post where a new release is coming or scheduled downtime is occurring. These are *not* active outages or issues.

## How do I make a post?

To generate an Maintenance Post:

1. Navigate to the following URL: https://qualys.projecttiy.com/status_page#maintenance-tab
2. Select the affected Platform in the dropdown menu
3. Enter in the Title (without the Platform)
    - Example: File Integrity Monitoring (FIM) 3.8.0.0 Release Notification

4. Enter in the Ticket Number
    - **NOTE**: This should be in a format such as CMB-123456 (2-3 letters, a hypen, then digits)

5. Enter in the Message
    - Example: A new release of File Integrity Monitoring 3.8.0.0 (FIM) is going to be released into production. The deployment is completely transparent to users and no impact is expected.

6. Enter in the Reference Link
    - **NOTE**: This should be in URL format such as https://www.qualys.com/docs/release-notes/qualys-file-integrity-monitoring-3.8-release-notes.pdf (http:// or https:// is required)
    - **NOTE**: If you need to specify *multiple* reference links, then please separate the links by comma (,). For example: https://qualys.com/release-notes/, https://qualys.com is *valid* but https://qualys.com/release-notes/https://qualys.com is *not valid*

7. Click the **Generate post** button
8. Confirm that the message appears in the green message box below the form
9. To get the correctly formatted Title or Message, click either the **Copy Title to Clipboard** or **Copy Message to Clipboard** button
    - If the button text changes to **Copied!**, then the text has been copied successfully

## What if I get an Error?

Any error messages will appear below the form in a red message box. Double-check that you've selected a Platform and filled in the Title and/or Message with something that makes sense. If you still receive errors or something doesn't appear to be working:

1. Navigate to the following URL: https://github.com/benowe1717/qualys-statuspage-update-tool/issues
2. Click the green **New issue** button
3. Fill in the title with a brief summary of your issue
4. Fill in the description with any errors you received and any steps you used to reproduce the issue
5. If you have any screenshots of the error, please attach them to the issue
6. Click the green **Submit new issue** button to open an issue
