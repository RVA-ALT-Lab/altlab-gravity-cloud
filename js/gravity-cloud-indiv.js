//let list = [['things',9], ['that',8], ['are',11], ['thingsan',7], ['actress',1], ['actressasdf',1], ['actressasdfasdf',1], ['actressasdfasdfI',4], ['hope',4], ['thats',4], ['not',4], ['a',22], ['curse',1], ['cursehere',3], ['my',3], ['details',1], ['detailsLorem',2], ['ipsum',12], ['dolor',3], ['sit',6], ['amet',6], ['consectetur',3], ['adipiscing',3], ['elit',12], ['Suspendisse',12], ['augue',15], ['laoreet',12], ['sed',12], ['sollicitudin',9], ['auctor',9], ['ultrices',9], ['id',15], ['lacus',9], ['Duis',6], ['eros',15], ['nisl',11], ['eleifend',3], ['ac',15], ['mattis',3], ['sodales',6], ['Aliquam',3], ['erat',9], ['volutpat',6], ['Curabitur',9], ['ligula',6], ['vel',12], ['fringilla',12], ['at',3], ['nibh',6], ['commodo',3], ['lectus',6], ['Cras',9], ['ante',15], ['non',9], ['justo',6], ['efficitur',3], ['nec',15], ['tincidunt',9], ['turpis',6], ['finibus',9], ['Phasellus',9], ['purus',6], ['tristique',9], ['quis',12], ['diam',9], ['imperdiet',3], ['blandit',12], ['metus',6], ['Maecenas',3], ['mi',3], ['nulla',9], ['varius',3], ['vehicula',3], ['et',12], ['venenatis',6], ['eget',9], ['Nunc',9], ['mauris',6], ['dignissim',6], ['nunc',3], ['eu',3], ['feugiat',6], ['Integer',3], ['viverra',6], ['velit',9], ['convallis',9], ['posuere',12], ['sagittis',3], ['sapien',9], ['lacinia',12], ['vulputate',12], ['faucibus',3], ['felis',6], ['hendrerit',6], ['risus',9], ['rhoncus',3], ['ut',15], ['Praesent',3], ['suscipit',9], ['magna',6], ['molestie',3], ['in',6], ['est',3], ['Nullam',12], ['elementum',3], ['rutrum',3], ['dapibus',6], ['Nam',3], ['pellentesque',15], ['tempor',3], ['vitae',6], ['Donec',6], ['egestas',3], ['lorem',9], ['libero',6], ['Fusce',3], ['enim',3], ['In',3], ['pretium',6], ['pulvinar',9], ['quam',6], ['vestibulum',3], ['tempus',6], ['ornare',9], ['dui',6], ['Nulla',3], ['tellus',6], ['bibendum',6], ['facilisis',6], ['consequat',3], ['Proin',3], ['porttitor',3], ['congue',3], ['cursus',3], ['semper',9], ['accumsan',3], ['tortor',6], ['sem',6], ['nisi',9], ['gravida',3], ['Etiam',3], ['orci',3], ['ex',6], ['nislLorem',1] ];
let list = cloudData.source;
let weight = cloudData.size;
let a = JSON.parse(list);
let b = [];
for(var i in a){
	b.push([i, a[i]]);
}

var attempt = WordCloud(document.getElementById('gc-cloud'), { 
  list: b,  
  fontFamily: 'Times, serif', 
  rotateRatio: 0.5,
  rotationSteps: 2,
  backgroundColor: '#fff',  
  drawOutOfBound: true,
  gridSize: Math.round(16 * jQuery('#gc-cloud').width() / 1024),
  weightFactor: function (size) {
    return Math.pow(size, weight) * jQuery('#gc-cloud').width() / 1024;
  },
  minFontSize: 200,

});