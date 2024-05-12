<?php
include 'db_connect.php';
session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $userData = array('username' => $username);
} else {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Politics</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Abel&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Abel&family=Aclonica&display=swap');
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../css/politics.css">
</head>

<body>

    <header>
        <div class="nav-bar">
            <div id="logo">
                <a href="../html/admin.php"><img src="../images/logo.png" width="30%"></a>
            </div>
            <div id="mid-nav">
                <input type="text" id="searchInput" placeholder="Search Posts">
                <button id="searchButton"><img src="../images/search.png" width="20"></button>
            </div>
        </div>
    </header>

    <main>
        <div class="nature"></div>
        <div class="right-panel" id="posts-container">
        </div>
    </main>

    <footer>
        <div class="footer">
            <p style="font-family: Verdana, Geneva, Tahoma, sans-serif;">© IntellectNest 2024</p>
        </div>
    </footer>

    <script>
        fetch('post.json')
            .then(response => response.json())
            .then(data => {
                const postsContainer = document.getElementById('posts-container');
                const allPosts = data;

                function displayPosts(posts) {
                    postsContainer.innerHTML = '';
                    posts.forEach(post => {
                        const postTitle = document.createElement('div');
                        postTitle.classList.add('post-title');
                        postTitle.innerHTML = `<h3>${post.title}</h3>
                        <br>
                        <p>${post.date}</p>`;
                        postsContainer.appendChild(postTitle);

                        const postElement = document.createElement('div');
                        postElement.classList.add('contents');
                        const fullText = post.paragraph;
                        const truncatedText = fullText.substring(0, 400) + '...';
                        postElement.innerHTML = `
                        <img src="${post.image}" alt="Post Image">
                        <p class="post-content">${truncatedText}</p>
                        <p class="read-more">Read More</p>
                        `;
                        postsContainer.appendChild(postElement);

                        const readMoreBtn = postElement.querySelector('.read-more');
                        const contentElement = postElement.querySelector('.post-content');

                        readMoreBtn.addEventListener('click', () => {
                            if (contentElement.textContent.length <= 400) {
                                contentElement.textContent = fullText;
                                readMoreBtn.style.display = 'none';
                            } else if (contentElement.textContent.endsWith('...')) {
                                contentElement.textContent = fullText;
                                readMoreBtn.textContent = 'Read Less';
                            } else {
                                contentElement.textContent = truncatedText;
                                readMoreBtn.textContent = 'Read More';
                            }
                        });
                    });
                }


                const userCategory = 'Politics';
                const username = '<?php echo isset($userData['username']) ? $userData['username'] : "" ?>';
                const userPosts = allPosts[userCategory].filter(post => post.author === username);
                displayPosts(userPosts);

                function searchPosts() {
                    const searchInput = document.getElementById('searchInput').value.toLowerCase();
                    const filteredPosts = userPosts.filter(post =>
                        post.title.toLowerCase().includes(searchInput)
                    );
                    displayPosts(filteredPosts);
                }
                document.getElementById('searchInput').addEventListener('input', searchPosts);

                const searchButton = document.getElementById('searchButton');
                searchButton.addEventListener('click', searchPosts);
            })
            .catch(error => console.error('Error:', error));
    </script>

</body>

</html>