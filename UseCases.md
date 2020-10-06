# Use cases for extra features

This usecases are complementary to the required ones: https://github.com/dntoll/1dv610/blob/master/assignments/A2_resources/UseCases.md


## UC5 Upload image

### Preconditions
A user is authenticated, UC1

### Main scenario
1. User wants to upload image
2. The system presents an upload form
3. User choses an image to upload
4. The system uploads the image and presents feedback message and link to image 

### Alernate scenario

4.a The system could not upload the image
    1. System presents feedback message
    2. Step 3 in main scenario


## UC6 View uploaded images

### Preconditions
A user is authenticated, UC1 and has uploaded in image UC5.

### Main scenario
1. The user wants to see all images uploaded
2. The system presents all images uploaded
3. The user choses one image to view 
4. The system presents that image
