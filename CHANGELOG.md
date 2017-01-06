# Change Log for WordPoints BuddyPress

All notable changes to this module will be documented in this file.

This module adheres to [Semantic Versioning](http://semver.org/) and [Keep a CHANGELOG](http://keepachangelog.com/).

## [Unreleased]

## [1.0.0] - 2017-01-06

### Added

- This changelog.
- Points and rank info is displayed on the Points tab on the member profiles.
- Messages component integration:
 - Message entity, with Content, Date Sent, Recipients, Sender, and Subject children, and Thread Accessible restriction.
 - Message Send hook action.
 - Message Send hook event.
- Friends component integration:
 - Friendship entity, with Date Created, Friend, and Initiator children.
 - Friendship Request, Withdraw, Accept, and Delete hook actions.
 - Friendship Request and Accept hook events.
- Groups component integration:
 - Group entity, with Creator, Date Created, Description, Name, Parent, Slug, and Status children, and Status Nonpublic restriction.
 - Group Activity Update entity, with Author, Content, Date Posted, and Group children, and Hidden and Spam restrictions.
 - Group Create, Delete, Join, and Leave, Member Ban, Unban, Remove, Delete Remove, Promote to Mod, Promote to Admin, and Demote, Invite User, Uninvite User, Invite Accept and Delete, Membership Request Send and Accept, Avatar Upload and Delete, Cover Image Upload and Delete, Activity Update Post, Ham, Spam, and Delete hook actions. 
 - Group Create, Join, Member Promote to Admin, Member Promote to Mod, Invite Send and Accept, Membership Request Send and Accept, Avatar Upload, Cover Image Upload, and Activity Update Post hook events.
- Activity component integration:
 - Activity entity with Date and User children, and hidden and spam restrictions.
 - Activity Update entity with Author, Content, and Date Posted children, and hidden and spam restrictions.
 - Activity Comment entity with Activity, Author, Content, Date Posted, and Parent children, and hidden and spam restrictions.
 - Activity Update Post, Ham, Spam, and Delete hook actions.
 - Activity Comment Post, Ham, Spam, and Delete hook actions.
 - Activity Favorite and Defavorite hook actions.
 - Activity Update Post, Comment Post, and Favorite hook events.
- xProfile component integration:
 - Profile Avatar Upload and Delete, Cover Image Upload and Delete hook actions.
 - Profile Avatar Upload and Cover Image Upload hook events.

[unreleased]: https://github.com/WordPoints/wordpoints/compare/master...HEAD
[1.0.0]: https://github.com/WordPoints/wordpoints/compare/...1.0.0
