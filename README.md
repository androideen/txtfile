# TxtFile
A small PHP library to help read and write data to text file

## Usage

Create class to handle a file

'''
//access the file
$file = new TxtFile('text.txt'); 
//access the file and create if it does not exist
$file = new TxtFile('text.txt', true); 
'''
