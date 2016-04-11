var React = require('react');
var ReactDOM = require('react-dom');
//noew app.jsx also responsible for connecting and loading the database
var ReactFire = require('reactfire');
var Firebase = require('firebase');
var rootUrl = 'https://glaring-torch-342.firebaseio.com/';
var Header = require('./header');
var List = require('./list');

var App = React.createClass({
  mixins: [ReactFire], //mixins -> copy the code in ReactFire to our component
	getInitialState: function(){
		return{
			items:{},
			loaded: false
		}
	},
  componentWillMount: function(){
    this.fb = new Firebase(rootUrl + 'items/');
    this.bindAsObject(this.fb, 'items'); //bindAsObject is a method in RectFire
    //this.state.items => contain the data from firebase
    //whenever firebase detect a change in the data, this.state will change, trigger rerender
    //this.fb.on('value', this.handleDataLoaded); //.on lets you listen to event, firebase has an event called 'value', firebase emits value as soon as it sees data flowing
		this.fb.orderByChild('order').on('value', this.handleDataLoaded);
  },
  render: function() {
		/*
		flow:
		app: items ={}, loaded = false  -> list: items={}
		app: items ={{-KEdT ...}}, loaded = false  -> list: items={{-KEdT ...}}  -> list-item: text=xxx, done=xxx... (this.bindAsObject(fb, 'items');)
		app: items ={{-KEdT ...}}, loaded = true  -> list: items={{-KEdT ...}}  -> list-item: text=xxx, done=xxx...   (fb.on('value', this.handleDataLoaded);)
		*/
    return <div className="row panel panel-default">
      <div className="col-md-8 col-md-offset-2">
        <h2 className="text-center">
          To-do List
        </h2>
        <Header itemsStore={this.firebaseRefs.items}/>
				<hr />
				<div className={"content " + (this.state.loaded ? 'loaded' : '')}>
					<List items={this.state.items}/>
					{this.deleteButton()}
				</div>
      </div>
    </div>
  },
	onDeleteDoneClick: function() {
    for(var key in this.state.items) {
      if(this.state.items[key].done === true) {
        this.fb.child(key).remove();
      }
    }
  },
	deleteButton: function() {
    if(!this.state.loaded) {
      return
    } else {
      return <div className="text-center clear-complete">
        <hr />
        <button
          type="button"
          onClick={this.onDeleteDoneClick}
          className="btn btn-default">
          Clear Complete
        </button>
      </div>
    }
  },
  handleDataLoaded: function(){
		this.setState({loaded: true});
	}
});

var element = React.createElement(App, {});
ReactDOM.render(element, document.querySelector('.container'));
