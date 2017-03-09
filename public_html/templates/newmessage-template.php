<!--modal shows when a user wants to write a new message-->
<div class="container">
	<div class="col-xs-12 col-md-6" id="new-message-modal">

		<button id="cancel">
			<!-- closes form -->
		</button>

		<!--instructions for users -->
		<div id="new-message-text">
			<p>Enter your message below</p>
		</div>
		<!--actual form-->
		<form action="POST" id="new-message-form">
			<!--an image of the produce they are offering-->
			<div class="formgroup">
				<p>{{messageSender}} to {{messageReceiver}}</p>
			</div>
			<!--allows users to write in further details about what they're offering -->
			<div class="formgroup">
					<textarea class="form-control" id="message-content" rows="5" name="message-content" placeholder="Enter your message here (Max 500 characters)">
					</textarea>
			</div>
			<!--submit the information-->
			<div class="formgroup" id="new-message-final-formgroup">
				<button id="submit">Submit</button>
			</div>
		</form>

	</div>
</div>
