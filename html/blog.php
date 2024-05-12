<?php
include 'db_connect.php';
session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $userData = array('username' => $username);
    $useremail = $_SESSION['email'];
} else {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["feed_back"])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $blogTopic = mysqli_real_escape_string($conn, $_POST['blogTopic']);
    $feedbackRating = mysqli_real_escape_string($conn, $_POST['feedbackRating']);
    $comment = mysqli_real_escape_string($conn, $_POST['message']);

    $insert_code = "INSERT INTO `blog_db`.`feedback` (`name`, `email`, `blogTopic`, `feedbackRating`, `comment`, `dt`) VALUES ('$name', '$email', '$blogTopic', '$feedbackRating', '$comment', current_timestamp())";
    $run_query = mysqli_query($conn, $insert_code);
    if ($run_query) {
        $subject = "Blog Feedback";
        $message = "Feedback on blog topic '' $blogTopic '' - $feedbackRating     Additional Comment: $comment";
        $sender = "From: dhimalprashant25@gmail.com";
        if (mail($email, $subject, $message, $sender)) {
            $info = "We've sent a feedback to respected email - $email";
            $_SESSION['info'] = $info;
            $_SESSION['email'] = $email;
            header('location: blog.php');
            exit();
        } else {
            $errors['otp-error'] = "Failed while sending email!";
        }
    } else {
        $errors['db-error'] = "Something went wrong!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Blogs</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Abel&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Abel&family=Aclonica&display=swap');
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../css/blog.css">
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

    <div class="feedback-container">
        <div class="feedback" id="feedbackFormContainer">
            <h2>Feedback Form</h2>
            <form id="feedbackForm" action="blog.php" method="post">
                <div class="form-group">
                    <label for="name">Your Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Blog Creater Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="blogTopic">Blog Topic:</label>
                    <input type="text" id="blogTopic" name="blogTopic" required>
                </div>
                <div class="form-group">
                    <label for="feedbackRating">Feedback Rating:</label>
                    <select id="feedbackRating" name="feedbackRating" required>
                        <option value="" disabled selected>Select Rating</option>
                        <option value="very-bad">Very Bad</option>
                        <option value="bad">Bad</option>
                        <option value="average">Average</option>
                        <option value="good">Good</option>
                        <option value="very-good">Very Good</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="message">Additional Comments:</label>
                    <textarea id="message" name="message"></textarea>
                </div>
                <input type="submit" value="Submit Feedback" name="feed_back">
            </form>
        </div>
    </div>

    <footer>
        <div class="footer">
            <p style="font-family: Verdana, Geneva, Tahoma, sans-serif;">© IntellectNest 2024</p>
        </div>
    </footer>

    <script>
        fetch('post.json')
            .then(response => response.json())
            .then(data => {
                const allPosts = data;
                const postsContainer = document.getElementById('posts-container');

                function displayPosts(posts) {
                    postsContainer.innerHTML = '';
                    posts.forEach(post => {
                        const postTitle = document.createElement('div');

                        postTitle.classList.add('post-title');
                        postTitle.innerHTML = `<h3>${post.title}</h3>
                        <p class="date">${post.date}</p>
                        <p class="author">${post.author}</p>
                        <p class="email">${post.email}</p>
                        <p class="category">${post.category}</p>
                        `;
                        postsContainer.appendChild(postTitle);
                        const postElement = document.createElement('div');
                        postElement.classList.add('contents');
                        const fullText = post.paragraph;
                        const truncatedText = fullText.substring(0, 400) + '...';
                        postElement.innerHTML = `
                            <img src="${post.image}" alt="Post Image">
                            <p class="post-content">${post.paragraph.substring(0, 400)}...</p>
                            <p class="read-more">Read More</p>
                            <a href="./blog.php#feedbackForm" id="toggleFeedback">Comment</a>`;
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

                displayPosts(Object.values(allPosts).flat());

                function searchPosts() {
                    const searchInput = document.getElementById('searchInput').value.trim().toLowerCase();
                    const filteredPosts = Object.values(allPosts).flat().filter(post =>
                        post.title.toLowerCase().includes(searchInput)
                    );
                    displayPosts(filteredPosts);
                }

                document.getElementById('searchInput').addEventListener('input', searchPosts);

                // document.querySelectorAll('.read-more').forEach(item => {
                //     item.addEventListener('click', event => {
                //         const parentElement = event.target.parentElement;
                //         const contentElement = parentElement.querySelector('.post-content');
                //         const fullText = data.find(post => post.title === parentElement.previousElementSibling.querySelector('h3').textContent).paragraph;

                //         if (contentElement.textContent.length <= 400) {
                //             contentElement.textContent = fullText;
                //             event.target.style.display = 'none';
                //         } else if (contentElement.textContent.endsWith('...')) {
                //             contentElement.textContent = fullText;
                //             event.target.textContent = 'Read Less';
                //         } else {
                //             contentElement.textContent = fullText.substring(0, 400) + '...';
                //             event.target.textContent = 'Read More';
                //         }
                //     });
                // });  not working

                function link_fcn(category) {
                    window.location.href = category + ".html";
                }

            })
            .catch(error => console.error('Error:', error));
    </script>

</body>

</html>