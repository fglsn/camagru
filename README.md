# Camagru

Camagru is a web-branch project from Ecole42 curriculum. Project was written from scratch and completed in roughly 3 weeks.  
  
Implemented using ***PHP*** on a server side, as well as ***Vanilla JavaScript***, ***Html*** and ***Css*** with some ***Bootstrap*** components on a fron-end.  
As a bonus I've Ajaxified couple of sections (***Fetch*** was used for 'Like' and 'Remove post' actions).

This application serves as a photo-gallery where user can:  
* upload pictures from filesystem or by using his web-camera
* apply stickers to their pictures
* leave likes and comments to other users posts
* handle their profile setting such as:

    * change email, username, password
    * subscribe/unsubscribe from email notifications
    * remove account  
      
User will recieve an email notification when his post was commented, unless user desided to unsubsctibe from notifications.  

# Project visual layout and short comments on each section

### Starting page ###  
  Index page will be responsible for the database migration, tables are created on the first run of the application.  
    
![alt text](https://github.com/fglsn/camagru/blob/main/screenshots/1-1.png?raw=true)  
  
### Signup page ###  
  All necessary validations are made on both: front and back-end sides.  
  After registration user will get an email message with a unique activation link.  
    
![alt text](https://github.com/fglsn/camagru/blob/main/screenshots/2.png?raw=true)  
  
### Login page ###  
  
![alt text](https://github.com/fglsn/camagru/blob/main/screenshots/3.png?raw=true)  
  
### Forgot password ###   
  After providing an email address user will get an email message with a unique password reset link.  
  The link will lead you to the password reset form.  
  
![alt text](https://github.com/fglsn/camagru/blob/main/screenshots/4.png?raw=true)  
  
### Main page / Main feed ###  
 Main page is paginated, there are five posts per page.  
 An id of the last post from the current page will be sent to the PHP script, which will fetch only next 5 posts from the db.  
 Users are able to comment and like any post. Comment sections and likes are disabled and comments are not loaded for not logged in visitors.  
   
![alt text](https://github.com/fglsn/camagru/blob/main/screenshots/8.png?raw=true)  
  
### Post upload page / Webcamera view ###  
  On this page user can upload new pictures: uploades from filesystem or made with webcamera.  
  Thumbnails of all webcam taken pictures are displayed in a sidebar, usar may delete any webcamera post from there.  
  By project specs user cannot take webcam snapshot without selecting one or multiple stickers.  
  Filesystem images may be uploaded with or without stickers.  
  Image manipulations/editing are done on a server side, as well as necessary validations.  
    
![alt text](https://github.com/fglsn/camagru/blob/main/screenshots/7.png?raw=true) ![alt text](https://github.com/fglsn/camagru/blob/main/screenshots/6.png?raw=true) 
    
### User profile page ###  
  All user creations are displayed on this page. Any post may be deleted by user from here as well.  
  
![alt text](https://github.com/fglsn/camagru/blob/main/screenshots/9.png?raw=true)  
  
### Profile settings ###  
  
![alt text](https://github.com/fglsn/camagru/blob/main/screenshots/11.png?raw=true)  
![alt text](https://github.com/fglsn/camagru/blob/main/screenshots/12.png?raw=true)  
  
All pages have responsive layout, application is compatible at least with Chrome and Mozilla Firefox  
