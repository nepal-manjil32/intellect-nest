window.onload = function() 
        {
            //! Retrieve the posts from local storage
            var posts = JSON.parse(localStorage.getItem('posts')) || [];
        
            //! Add each post to the right panel
            displayPosts(posts);
        };
        
        function displayPosts(posts) 
        {
            var rightPanel = document.querySelector(".right-panel");
            rightPanel.innerHTML = ''; // Clear the right panel
            posts.forEach(function(post, index) 
            {
                var postElement = document.createElement("div");
                postElement.className = "post";
                postElement.innerHTML = "<h2>" + post.title + "</h2>";
                if (post.image) {
                    postElement.innerHTML += "<img src='" + post.image + "' style='width: 100%;'>";
                }
                postElement.innerHTML += "<p>" + post.paragraph + "</p><p id='category_'>Category: " + post.category + "</p>";
                rightPanel.appendChild(postElement);
            });
        }

    
        // function removePost(index) 
        // {
        //     //! Retrieve the posts from local storage
        //     var posts = JSON.parse(localStorage.getItem('posts')) || [];
        
        //     //! Remove the post at the specified index
        //     posts.splice(index, 1);
        
        //     //! Update local storage with the new array of posts
        //     localStorage.setItem('posts', JSON.stringify(posts));
        
        //     //! Refresh the page to reflect the changes
        //     location.reload();
        // }