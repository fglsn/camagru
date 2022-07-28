# Camagru

Camagru is an Ecole42 curriculum web-branch project. The project was written from scratch and completed in roughly 3 weeks.  
  
Implemented using ***PHP*** on the server side, as well as ***Vanilla JavaScript***, ***HTML***, and ***CSS*** with some ***Bootstrap*** components on the front-end. As a bonus, I've Ajaxified a couple of sections (***Fetch*** was used for 'Like' and 'Remove post' actions).  
  
This application serves as a photo-gallery where user can:  
* upload pictures from filesystem or by using his web-camera
* apply stickers to their pictures
* leave likes and comments to other  users' posts
* handle their profile setting such as:

    * alter your email, username, and password
    * subscribe/unsubscribe from email notifications
    * remove account  
      
A user will receive an email notification when his post is commented, unless user decides to unsubscribe from notifications.  
  
# Project visual layout and short comments on each section  
  
### Starting page ###  
 An index page will be responsible for the database migration. Tables are created on the first run of the application.  
   
![alt text](https://github.com/fglsn/camagru/blob/main/screenshots/1-1.png?raw=true)  
  
### Signup page ###  
  All necessary validations are made on both: front and back-end sides.  
  After registering, the user will get an email message with a unique activation link.  
    
![alt text](https://github.com/fglsn/camagru/blob/main/screenshots/2.png?raw=true)  
  
### Login page ###  
  
![alt text](https://github.com/fglsn/camagru/blob/main/screenshots/3.png?raw=true)  
  
### Forgot password ###   
  After providing an email address, the user will get an email message with a unique password reset link.  
  The link will take you to the password reset form.  
  
![alt text](https://github.com/fglsn/camagru/blob/main/screenshots/4.png?raw=true)  
  
### Main page / Main feed ###
 The main page is paginated, there are five posts per page.  
 An id of the last post from the current page will be sent to the PHP script, which will fetch only the next 5 posts from the db.  
 Users are able to comment and like any post. Comment sections and likes are disabled and comments are not loaded for not logged in visitors.  
 Upd: Comment can be now removed by post owner or comment owner. Also elapsed timestamps ("N time ago") are added to posts and comments.
   
![alt text](https://github.com/fglsn/camagru/blob/main/screenshots/8.png?raw=true)  
  
### Post upload page / Webcamera view ###  
On this page user can upload new pictures: from filesystem or made with webcamera.  
Thumbnails of all webcam-taken pictures are displayed in a sidebar, from which the user can delete any webcam post.  
By project specs, a user cannot take a webcam snapshot without selecting one or multiple stickers.  
Filesystem images may be uploaded with or without stickers.  
Image manipulations/editing are done on the server side, as well as necessary validations.  
    
![alt text](https://github.com/fglsn/camagru/blob/main/screenshots/7.png?raw=true) ![alt text](https://github.com/fglsn/camagru/blob/main/screenshots/6.png?raw=true) 
    
### User profile page ###  
  All user creations are displayed on this page. Any post may be deleted by a user from here as well.  
  
![alt text](https://github.com/fglsn/camagru/blob/main/screenshots/9.png?raw=true)  
  
### Profile settings ###  
  
![alt text](https://github.com/fglsn/camagru/blob/main/screenshots/11.png?raw=true)  
![alt text](https://github.com/fglsn/camagru/blob/main/screenshots/12.png?raw=true)  
  
All pages have a responsive layout. The application is compatible at least with Chrome and Mozilla Firefox.  
