<form action="/shop/register" method="POST" enctype="multipart/form-data">
@csrf
<input type="text" name="name" placeholder="Shop Name" required>
<input type="email" name="email" placeholder="Email" required>
<input type="text" name="phone" placeholder="Phone">
<textarea name="description" placeholder="Description"></textarea>
<input type="file" name="logo">
<button type="submit">Register Shop</button>
</form>