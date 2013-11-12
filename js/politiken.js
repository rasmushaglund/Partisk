App = Em.Application.create({LOG_TRANSITIONS: true});

App.Store = DS.Store.extend({
    revision: 12,
    //adapter: 'DS.FixtureAdapter'
    adapter: DS.FixtureAdapter.create({latency: 0})
});

App.Router.map(function(){
    this.route('partys');
    this.resource("party", function () {
	this.route("index", {path: "/:party_id"});
    });
    this.route("questions");
    this.resource("question", function () {
	this.route("index", {path: "/:question_id"});
    });
    this.route("answers");
    this.resource("answer", function () {
	this.route("index", {path: "/:answer_id"});
    });
});

App.ApplicationController = Ember.ArrayController.extend({
    init: function () {
        var socialdemokraterna = App.Party.createRecord({name: "Socialdemokraterna", logo: "img/socialdemokraterna.png"});
        var moderaterna = App.Party.createRecord({name: "Moderaterna", logo: "img/moderaterna.png"});
        var vansterpartiet = App.Party.createRecord({name: "Vänsterpartiet", logo: "img/vansterpartiet.png"});
        var miljopartiet = App.Party.createRecord({name: "Miljöpartiet", logo: "img/miljopartiet.png"});
        var kristdemokraterna = App.Party.createRecord({name: "Kristdemokraterna", logo: "img/kristdemokraterna.png"});
        var centerpartiet = App.Party.createRecord({name: "Centerpartiet", logo: "img/centerpartiet.png"});
        var folkpartiet = App.Party.createRecord({name: "Folkpartiet", logo: "img/folkpartiet.png"});
        var piratpartiet = App.Party.createRecord({name: "Piratpartiet", logo: "img/piratpartiet.png"});
        var sverigedemokraterna = App.Party.createRecord({name: "Sverigedemokraterna", logo: "img/sverigedemokraterna.png"});

        var alliansfrihet = App.Question.createRecord({title: "Alliansfrihet"});    
        var alliansfrihetS = App.Answer.createRecord({answer: "Ja", question: alliansfrihet, party: socialdemokraterna});
        var alliansfrihetM = App.Answer.createRecord({answer: "Nej", question: alliansfrihet, party: moderaterna});
        var alliansfrihetV = App.Answer.createRecord({answer: "Ja", question: alliansfrihet, party: vansterpartiet});
        var alliansfrihetMP = App.Answer.createRecord({answer: "Ja", question: alliansfrihet, party: miljopartiet});
        var alliansfrihetKD = App.Answer.createRecord({answer: "Nej", question: alliansfrihet, party: kristdemokraterna});
        var alliansfrihetC = App.Answer.createRecord({answer: "Nej", question: alliansfrihet, party: centerpartiet});
        var alliansfrihetFP = App.Answer.createRecord({answer: "Nej", question: alliansfrihet, party: folkpartiet});
        //var alliansfrihetPP = App.Answer.createRecord({answer: "-", question: alliansfrihet, party: piratpartiet});
        var alliansfrihetSD = App.Answer.createRecord({answer: "Ja", question: alliansfrihet, party: sverigedemokraterna});

        var sverigemedinato = App.Question.createRecord({title: "Sverige med i NATO"});
        var sverigemedinatoS = App.Answer.createRecord({answer: "Nej", question: sverigemedinato, party: socialdemokraterna});
        var sverigemedinatoM = App.Answer.createRecord({answer: "Ja", question: sverigemedinato, party: moderaterna});
        var sverigemedinatoV = App.Answer.createRecord({answer: "Nej", question: sverigemedinato, party: vansterpartiet});
        var sverigemedinatoMP = App.Answer.createRecord({answer: "Nej", question: sverigemedinato, party: miljopartiet});
        var sverigemedinatoKD = App.Answer.createRecord({answer: "Nej", question: sverigemedinato, party: kristdemokraterna});
        var sverigemedinatoC = App.Answer.createRecord({answer: "Ja", question: sverigemedinato, party: centerpartiet});
        var sverigemedinatoFP = App.Answer.createRecord({answer: "Ja", question: sverigemedinato, party: folkpartiet});
        //var sverigemedinatoPP = App.Answer.createRecord({answer: "-", question: sverigemedinato, party: piratpartiet});
        var sverigemedinatoSD = App.Answer.createRecord({answer: "Nej", question: sverigemedinato, party: sverigedemokraterna});
    }
});


App.QuestionsController = Ember.ArrayController.extend({

    toggleParty: function (party) {
        var status = party.get("disabled");

        if (status) {
            party.set("disabled", false);
        } else {
            party.set("disabled", true);    
        }
    }
});
App.QuestionIndexController = Ember.ObjectController.extend({
    
});

Ember.Handlebars.helper('findAnswerForQuestion', function(question, party, options) {
    
});

App.QuestionsRoute = Ember.Route.extend({
    setupController: function (controller) {
       controller.set("model", App.Question.find());
	   controller.set("partys", App.Party.find());
    }
});

App.InlineAnswerController = Ember.Object.create({

});

App.QuestionsView = Ember.View.extend({
    templateName: "questions"
});

App.ApplicationRoute = Ember.Route.extend({
    setupController: function (controller) {
        controller.set('partys', App.Party.find());
    }   
});

App.PartyMenuController = Ember.ArrayController.extend({
    model: function () {
        console.log("hehehe");
    }
});

App.PartyMenu = Ember.View.extend({
    templateName: "partyMenu",
    controller: App.PartyMenuController
});

App.LogoView = Ember.View.extend({
    templateName: "logo",
    classNames: ["logo"]
});

App.InlineAnswerView = Ember.View.extend({
    templateName: "inline-answer",
    didInsertElement: function () {
        
    },

    answerObject: function () {
        var view = this;
        var result = new Ember.RSVP.Promise(function (resolve) {
            var question = view.get("question");
            var party = view.get("party")
            view.get("question.answers").forEach(function (answer) {
                answer.then(function (answer) {
                    answer.get("party").then(function (answerParty) {
                        if (answerParty.get("id") == party.get("id")) {
                            resolve(answer);
                        }
                    });
                });
            });
        });
        
        return result.then(function (value) {
            view.set("answerObject", value);
        });
    }.property("answerObject")
});