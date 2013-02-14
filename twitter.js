			
	function twitter (search) {

			new TWTR.Widget({
				  version: 2,
				  type: 'search',
				  search: search,
				  interval: 6000,
				  title: 'TekkieValley',
				  subject: 'Top Tech Buzz',
				  width: 213,
				  height: 300,
				  theme: {
					shell: {
					  background: '#6ce4ff',
					  color: '#ffffff'
					},
					tweets: {
					  background: '#ffffff',
					  color: '#444444',
					  links: '#1985b5'
					}
				  },
				  features: {
					scrollbar: false,
					loop: true,
					live: true,
					hashtags: true,
					timestamp: true,
					avatars: false,
					toptweets: true,
					behavior: 'default'
				  }
				}).render().start();
				
				
	}
	
	function create_login() {
			  twttr.anywhere(function (T) {
				T("#login_twitter").connectButton();
			  });
		}