# Test cases for extra features

This test cases are complementary to the required ones:
https://github.com/dntoll/1dv610/blob/master/assignments/A2_resources/TestCases.md


## TC 5.1 Upload image

When a user wants to upload an image

### Input

- Testcase 1.7
- Choose an image to upload (use [this image](http://casaolive.es/1dv610/test_images/ok.jpg)) and press "Upload"

### Output

- An upload form is shown
- File, browse is empty
- A success message "The file ok.jpg has been uploaded." is shown with a link to the image

![ok upload](http://casaolive.es/1dv610/test_images/okupload.png)


## TC 5.2 Upload image with too large image

A user wants to upload an image but it is too large

### Input

- Testcase 1.7
- Choose an image to upload (use [this image](http://casaolive.es/1dv610/test_images/large.jpg)) and press "Upload"

### Output

- An upload form is shown
- File, browse is empty
- A message "The image is too large, max allowed 500000" is shown

![too large](http://casaolive.es/1dv610/test_images/large.png)

## TC 5.3 Upload image with not an image

http://casaolive.es/1dv610/test_images/notimage.css

### Input

- Testcase 1.7
- Choose an image to upload (use [this image](http://casaolive.es/1dv610/test_images/notimage.css)) and press "Upload"

### Output

- An upload form is shown
- File, browse is empty
- A message "File is not an image." is shown

![not an image](http://casaolive.es/1dv610/test_images/notimage.png)


## TC 5.4 Upload image with no image

### Input

- Testcase 1.7
- Press "Upload" without selecting an image

### Output

- An upload form is shown
- File, browse is empty
- A message "You must select an image to upload." is shown

![no image](http://casaolive.es/1dv610/test_images/noimage.png)

## TC 6.1 View uploaded images

### Input

- Testcase 1.7 and 5.1
- Click on "View images"

### Output

- The title "List images" is shown
- The image uploaded previously in 5.1 is shown in the list

![list images](http://casaolive.es/1dv610/test_images/listimages.png)

## TC 6.1 View a specific uploaded image

### Input

- Testcase 1.7 and 5.1
- Click on "View images"
- Click on an image to view.

### Output

- The browser displays the image 

![list image](http://casaolive.es/1dv610/test_images/ok.jpg)
