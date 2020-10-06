# 1dv610 a2 + a3
Assignment 2 in course 1dv610
Learn about the assignment on  [CoursePress](https://coursepress.lnu.se/kurs/introduktion-till-mjukvarukvalitet/02-Laborationsuppgifter/3.%20Requirements).


## What has been done

This is a single page app made in php. The main goal was to set up a working app, fullfilling requirements. The organisation and design is therefore not the best and some code has to be re-arranged when the app expands. It is possible that design is a little unclear and therefore I thought I would explain.

**index.php**

Starting the app and inisiating classes.

**Model**

The model classes defines the storage and the design of the storage.

**Controller**

The controller classes work with input data and generate new output data (in html or session for example). The class authentication is not yet implemented but is good to have if the app expands and there will be many different ways to authenticate a user. Right now this functionality is User and UserStorage class.

**View**

The classes in view are the layouts, like templates, where the data is retrieved from the controller, if necessary.


## Future features and implementation

**Fullfill all requirements**

First of all, many possible requirements are not yet implemented. I have begun to implement a few UC but not completed them. To *sign in with cookies* and *register a user* are not implemented but started.

**Exceptions**

It could be a good idea to add exceptions and check for errors like "is session started" or if database doesn't exsist.

**Unclear User/UserStorage**

I feel that I have an unclear separation between User and UserStorage classes and basically User is very empty at the moment. It mostly gets data from UserStorage. The idea is that UserStorage only works with saving/deleting data that is connected to user.
