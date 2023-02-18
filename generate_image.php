<?php
  // Get the user's text input from the form data
  $user_text = $_POST["user_text"];

  // Call the DALL-E API to generate an image based on the user's input
  $url = generate_image($user_text);

  // Display the generated image on the web page
  echo "<img src='$url'>";
?>

<?php
  function generate_image($prompt) {
    $api_key = "OPENAI_API_KEY";
    $headers = array(
      "Content-Type: application/json",
      "Authorization: Bearer $api_key"
    );
    $data = array(
      "model" => "image-alpha-001",
      "prompt" => "$prompt",
      "num_images" => 1,
      "size" => "512x512",
      "response_format" => "url"
    );
    $data_string = json_encode($data);
    $ch = curl_init("https://api.openai.com/v1/images/generations");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($ch);
    $response = json_decode($result, true);
    $url = $response["data"][0]["url"];
    return $url;
  }
?>