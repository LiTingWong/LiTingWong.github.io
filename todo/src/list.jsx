var React = require('react');
var ListItem = require('./list-item');

module.exports = React.createClass({
  render: function(){
		return <div>
			{this.renderList()}
		</div>
  },
	renderList: function(){
		if(!this.props.items){ this.props.items== null || Object.keys(this.props.items).length ==0
			return <h4>
				Add a todo to get started.
			</h4>
		}
		else{
			var children = [];
			for(var key in this.props.items){
				//have an unique key to each list items (require)
				//React decides key property is not accessible inside the object
				//so we manually add the key to our item
				var item = this.props.items[key];
				item.key = key;
				children.push(
					<ListItem
						item={item}
						key={key}
					/>
				)
			}
		}
		return children;
	}
});
