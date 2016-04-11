var React = require('react');
var rootUrl = 'https://glaring-torch-342.firebaseio.com/';
var Firebase = require('firebase');

module.exports = React.createClass({
	getInitialState: function(){
		return {
			text: this.props.item.text,
			done: this.props.item.done,
			textChanged: false
		}
	},
	componentWillMount: function(){
    this.fb = new Firebase(rootUrl + 'items/' + this.props.item.key);
  },
	render: function(){
		return <div className="input-group">
			<span className="input-group-addon">
				<input 
					type="checkbox"
					onChange = {this.handleDoneChange}
					checked={this.state.done}
				/>
			</span>
			<input 
				type="text"
				className = "form-control"
				disabled={this.state.done}
				value={this.state.text}
				onChange={this.handleTextChange}
			/>
			<span className="input-group-btn">
				{this.changesButtons()}
				<button
          className="btn btn-default"
          onClick={this.handleDeleteClick}
          >
					Delete
				</button>
			</span>
		</div>
	},
	changesButtons: function() {
    if(!this.state.textChanged) {
      return null
    } 
		else {
      return [
        <button
          className="btn btn-default"
          onClick={this.handleSaveClick}
          >
          Save
        </button>,
        <button
          onClick={this.handleUndoClick}
          className="btn btn-default"
          >
          Undo
        </button>
      ]
    }
  },
	handleSaveClick: function() {
    this.fb.update({text: this.state.text});
    this.setState({textChanged: false});
  },
	handleUndoClick: function() {
    this.setState({
      text: this.props.item.text,
      textChanged: false
    });
  },
	handleTextChange: function(event) {
    this.setState({
      text: event.target.value,
      textChanged: true
    });
  },
	handleDoneChange: function(event){
		//want to use state because we need to assign the original checked state (assign it to state: done) from database
		//then, each time the checked is changed, the checked value needs to be updated (by state refresh)
		var update = {done: event.target.checked};
		this.setState(update); //doesnt need this because when database updated, rerender from app.jsx trigger
														// still need this because in the render fuction when you assigned value to checked, 
														//then the checked can not be updated by clicking it -> onChange won't trigger
		this.fb.update(update);
	},
	handleDeleteClick: function() {
    this.fb.remove();
  }
});