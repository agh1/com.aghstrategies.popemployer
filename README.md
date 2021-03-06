# Populate Employer for Anonymous Users (CiviCRM Extension)

When an anonymous visitor fills profiles and other forms having email address and
employer fields, this extension searches for an individual with a matching email
address and populates the form with his or her employer.  **This requires granting
the "access AJAX API" permission to anonymous users.**

This is meant to address problems in
[CRM-10128](https://issues.civicrm.org/jira/browse/CRM-10128) (leaving the
employer blank on a profile will unset your current employer if you have one)
and problems of people typing organization names different ways.

![Screenshot of populated employer](images/popEmp.png)
