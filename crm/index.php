<?php 
require('../header.php');	 
include('../auth/auth.php');

authenticate(2);

?>
	 <form>
	    <div class="form-group">
	      <label for="exampleInputEmail1">Business Name</label>
	      <input type="input" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Evil Corp LLC">
	    </div>
	    <div class="form-group">
	      <label for="exampleInputEmail1">Contact Name</label>
	      <input type="input" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Mr. ROBOT">
	    </div>
	    <div class="form-group">
	      <label for="exampleInputEmail1">Customer Email</label>
	      <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="mr_robot@evilcorp.com">
	    </div>
	    <div class="form-group">
	      <label for="exampleInputEmail1">Customer Phone</label>
	      <input type="input" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="123-456-7890">
	    </div>
	    <div class="form-group">
	      <label for="exampleInputEmail1">Lead Rating</label><br />
	      <select name="LeadRating">
		<option value="Hot">Hot</option>
		<option value="Warm">Warm</option>
		<option value="Cold">Cold</option>
		<option value="Dead">Dead</option>
	      </select>		
	    </div>
	    <div class="form-group">
	      <label for="exampleInputPassword1">Notes</label><br />
	      <textarea rows="4" style="width: 100%; margin-left: auto; margin-right: auto;"></textarea>
	    </div>
	    <button type="submit" class="btn btn-primary">Submit</button>
	  </form>


	  <!-- HEre in end the test code stuff -->
	</div>
      </div>

        <div class="card" style="width: 80%; margin-bottom:10px; margin-left:auto; margin-right:auto;">
          <div class="card-body">
            <h5 class="card-title">Evil Corp.</h5>
            <ul>
              <li>Date: 01/01/1970</li>
              <li>Contact Name: That one Guy</li>
              <li>Contact Email: oneguy@evilcorp.com</li>
              <li>Contact Phone: N/A</li>
              <li>Lead Rating: Cold</li>
            <ul>
            <h6>Notes</h6>
            <p>A card is a flexible and extensible content container. It includes options for headers and footers, a wide variety of content, contextual background colors, and powerful display options. If you’re familiar with Bootstrap 3, cards replace our old panels, wells, and thumbnails. Similar functionality to those components is available as modifier classes for cards</p>
          </div>
        </div>

	<div class="card" style="width: 80%; margin-bottom:10px; margin-left:auto; margin-right:auto;">
	  <div class="card-body">
	    <h5 class="card-title">Evil Corp.</h5>
	    <ul>
	      <li>Date: 01/01/1969</li>
	      <li>Contact Name: That one Guy</li>
	      <li>Contact Email: oneguy@evilcorp.com</li>
	      <li>Contact Phone: N/A</li>
	      <li>Lead Rating: Cold</li>
	    <ul>
	    <h6>Notes</h6>
	    <p>A card is a flexible and extensible content container. It includes options for headers and footers, a wide variety of content, contextual background colors, and powerful display options. If you’re familiar with Bootstrap 3, cards replace our old panels, wells, and thumbnails. Similar functionality to those components is available as modifier classes for cards</p>
	</div>
	</div>
<?php require('../footer.php'); ?>
