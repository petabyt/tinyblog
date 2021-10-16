# TinyBlog
Single File HTML/CSS/PHP blog in less than 100 lines.  
See it in action: http://petabyte.heb12.com/blog/  

## Features
- Tiny source code. Just pull index.php and customize.  
- Minimal markdown parser. Easy to customize to your liking.  

## Setup
In the `posts` folder, create a file named "1" for the first  
post, "2" for the second, and so on.  

## theme

First rename the `index.php` file to `index-heme-default.php`.

To change the theme, please rename the file `index-heme-simple.php` to `index.php` .

## Markdown Syntax


TinyBlog has a built-in Markdown parser. It supports most of the typical  
Markdown syntax, but has some additional features:  

- Type `---` to insert a "Read More" link, and cut off the rest of the text.  
- Use `\*` to prevent the asterisk from being recognized.  
