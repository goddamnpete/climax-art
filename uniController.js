 var app = angular.module('app', ['ngRoute', 'ui.bootstrap', 'infiniteScroll']);

app.config(function($routeProvider) {
        $routeProvider
        	.when('/', {
        		templateUrl : 'partial-results.html',
                controller  : 'uniController'
        	})
        	.when('/:char1/:a1/:g1/:p1/:char2/:a2/:g2/:p2/:w/:loc/:vers', {
                templateUrl : 'partial-results.html',
                controller  : 'uniController'
            })
            
    });
    
app.controller("uniController", function($rootScope, $scope, $http, $location, $routeParams, $timeout) {
	$scope.load = true;
	$scope.c1 = 'any';
	$scope.c2 = 'any';
	$scope.a1 = 'any';
	$scope.a2 = 'any';
	$scope.g1 = '0';
	$scope.g2 = '0';
	$scope.p1 = '';
	$scope.p2 = '';
	$scope.winner = '0';
	$scope.locale = 'any';
	$scope.vers = '0';
	$rootScope.reportup = false;
	$scope.predicate = '-date';
	$scope.allchar = ['any',  'Asuna',
                    'Shana',
                    'Misaka',
                    'Kirino',
                    'Shizuo',
                    'Kuroyukihime',
                    'Tomoka',
                    'Kirito',
                    'Miyuki',
                    'Taiga',
                    'Yukina',
                    'Rentaro',
                    'Akira',
                    'Selvaria',
                    'Emi',
                    'Quenser',
                    'Kuroko',
                    'Tatsuya'];
    $scope.imgs = ['asuna.png', 
    				'shana.png', 
    				'mikoto.png',
    				'kirino.png', 
    				'shizuo.png', 
    				'kuroyuki.png', 
    				'tomoka.png',
    				'kirito.png', 
    				'miyuki.png', 
    				'taiga.png', 
    				'yukina.png', 
    				'rentaro.png', 
    				'akira.png', 
    				'selvaria.png',
    				'emi.png',
    				'quenser.png',
    				'kuroko.png',
    				'tatsuya.png'];
    $scope.allassist = ['Wilhelmina',
						'Leafa',
						'Touma',
						'Kuroneko',
						'Celty',
						'Haruyuki',
						'Holo',
						'Boogiepop',
						'Sadao',
						'Hinata',
						'Koko',
						'Kino',
						'Mashiro',
						'Erio',
						'Tatsuya',
						'Ryuuji',
						'Kojou',
						'Enju',
						'Pai',
						'Alicia',
						'Dokuro-chan',
						'Accelerator',
						'Izaya',
						'Froleytia',
						'Asama',
						'Iriya',
						'Uiharu',
						'Miyuki'];
	$scope.aimgs = ['will.png',
						'leafa.png',
						'touma.png',
						'kuroneko.png',
						'celty.png',
						'haruyuki.png',
						'holo.png',
						'boogiepop.png',
						'sadao.png',
						'hinata.png',
						'koko.png',
						'kino.png',
						'mashiro.png',
						'erio.png',
						'tatsuya.png',
						'ryuuji.png',
						'kojou.png',
						'enju.png',
						'pai.png',
						'alicia.png',
						'dokuro.png',
						'accelerator.png',
						'izaya.png',
						'frolaytia.png',
						'tomoasama.png',
						'iriya.png',
						'uiharu.png',
						'miyuki.png'
					];
	$scope.$location = {};
	$rootScope.page = 0;
	$http.post('fetcharcades.php', {}). success(function(data, status, headers, config) {
				$scope.arcades = data;
		}); 
 	$scope.watching = -1;
 	$scope.logWatch = function(mid) {
 	//	console.log(mid);
 		$scope.watching = mid;
 	}
   	$scope.reportMatch = function(matchid) {
   //		console.log(matchid);
        
   	}
   	$scope.searchPlayer = function(player) {
   		$scope.resetFilters();
   		$scope.p1 = player;
   	//	console.log($scope.p1);
   		$scope.loadMatches();
   	}
   	$scope.newfunction = function(matchid) {
   	//	console.log(matchid);
   		$scope.reportup = true;
   		$scope.repMID = matchid;
   	//	console.log($scope.repMID == matchid);
   		$scope.reportresponse = '';
   	}
   	$scope.alterBG = function() {
	    console.log($scope.vers);
	    if($scope.vers == 0) {
	    	document.getElementById("bg").style.background = "url('LogoEditIGNITE.png') 0px -50px no-repeat, url('IGNITE.png') top center no-repeat #00948e";
	    }
	    if($scope.vers == 1) {
	      document.getElementById("bg").style.background = "url('LogoEdit.png') 0px -50px no-repeat, url('BGOriginal.png') top center no-repeat #010039";
	    }
	    if($scope.vers == 2) {
	    	console.log('v2');
	      document.getElementById("bg").style.background = "url('LogoEditIGNITE.png') 0px -50px no-repeat, url('IGNITE.png') top center no-repeat #00948e";
	    }
    
  	}
   	$scope.submitReport = function() {
   		$http.post('submitreport.php', {'mid': $scope.repMID, 'reason':$scope.reason}). success(function(data, status, headers, config) {
   			if(data.trim() == 'complete') {
   				$scope.reportresponse = 'Report Submitted, Thank you.';
   				$scope.reason = '';
   				$timeout(function() {
   					$scope.reportup = false;
   				}, 2000);
   			}
   			else {
   				$scope.reportresponse = 'Report submittion failed.';
   			}
   		})
   	} 
	$rootScope.$on('$routeChangeSuccess', function () {
		if($routeParams.char1 == undefined) {
			$scope.loadLatest();
		}
		else { 
            $scope.c1 = $routeParams.char1;
	        $scope.c2 = $routeParams.char2;
	        $scope.a1 = $routeParams.a1;
	        $scope.a2 = $routeParams.a2;
	        $scope.g1 = parseFloat($routeParams.g1);
	        $scope.g2 = parseFloat($routeParams.g2);
	        if($routeParams.p1 == 'NONE') {
	        	$scope.p1 = '';
	        }
	        else {
	        	$scope.p1 = $routeParams.p1;
	        }
	        if($routeParams.p2 == 'NONE') {
	        	$scope.p2 = '';
	        }
	        else {
	        	$scope.p2 = $routeParams.p2;
	        }
	        $scope.winner = $routeParams.w;
	        $scope.locale = $routeParams.loc;
	        $scope.vers = $routeParams.vers;
	        $scope.loadMatches();
        }
        
        });
	/*$http.post('latest.php', {}).success(function(data, status, headers, config) {
					console.log(data);
					$scope.dbresults = data;
				 }); */
 
 	$scope.selectImg = function(char) {
 		var pos = $scope.allchar.indexOf(char.trim());
 		return "char/"+$scope.imgs[pos-1];
 	}
 	$scope.selectAImg = function(char) {
 		var pos = $scope.allassist.indexOf(char.trim());
 		return "assists/"+$scope.aimgs[pos];
 	}
 	$scope.loadNext = function() {
 		$scope.load = false;
 	//	console.log("LOADING NEXT");
   		$rootScope.page = $rootScope.page+1;	
		$http.post('fetchmatches.php', {'char1': $scope.c1, 'char2':$scope.c2, 'page':$rootScope.page, 
			'assist1':$scope.a1, 'assist2':$scope.a2, 'grade1':$scope.g1, 'grade2':$scope.g2,
			'player1':$scope.p1, 'player2':$scope.p2, 'winner':$scope.winner, 'locale':$scope.locale, 'version':$scope.vers}). success(function(data, status, headers, config) {
				
			if(data.length == 0) {
		      	$scope.load = false;
		 //     	console.log("ZTOP");
		      }
		      else{
				for (var i = 0; i < data.length; i++) {
			        $rootScope.dbresults.push(data[i]);

			      }
			      $scope.load = true;
		      }
		});
		
   	}
	$scope.loadMatches = function() {
		$rootScope.page = 0;	
	//	console.log($scope.locale);
		$http.post('fetchmatches.php', {'char1': $scope.c1, 'char2':$scope.c2, 'page':$rootScope.page, 
			'assist1':$scope.a1, 'assist2':$scope.a2, 'grade1':$scope.g1, 'grade2':$scope.g2,
			'player1':$scope.p1, 'player2':$scope.p2, 'winner':$scope.winner, 'locale':$scope.locale, 'version':$scope.vers}). success(function(data, status, headers, config) {	
			$rootScope.dbresults = data;
		//	console.log($rootScope.dbresults);
			$scope.changeURL();
			$scope.alterBG();
		});
		
	};
	$scope.loadAssits = function(num) {
		if(num == 1) {
			$http.post('fetchassists.php', {'char': $scope.c1}). success(function(data, status, headers, config) {
				$scope.assists1 = data;
			});
		}
		if(num == 2) {
			$http.post('fetchassists.php', {'char': $scope.c2}). success(function(data, status, headers, config) {
				$scope.assists2 = data;
			});
		}	
	}
	$scope.changeURL = function() {
	//	console.log("The current path: " + $location.path());
     //   console.log("Changing url...");
     if($scope.p1 == '' && $scope.p2 == '') {
     	$location.path('/'+$scope.c1+'/'+$scope.a1+'/'+$scope.g1+'/'+'NONE'+'/'+$scope.c2+'/'+$scope.a2+'/'+$scope.g2+'/'+'NONE'+'/'+$scope.winner+'/'+$scope.locale+'/'+$scope.vers);
     }
     else if($scope.p1 == '') {
     	$location.path('/'+$scope.c1+'/'+$scope.a1+'/'+$scope.g1+'/'+'NONE'+'/'+$scope.c2+'/'+$scope.a2+'/'+$scope.g2+'/'+$scope.p2+'/'+$scope.winner+'/'+$scope.locale+'/'+$scope.vers);
     }
     else if($scope.p2 == '') {
     	$location.path('/'+$scope.c1+'/'+$scope.a1+'/'+$scope.g1+'/'+$scope.p1+'/'+$scope.c2+'/'+$scope.a2+'/'+$scope.g2+'/'+'NONE'+'/'+$scope.winner+'/'+$scope.locale+'/'+$scope.vers);
     }
     else{
        $location.path('/'+$scope.c1+'/'+$scope.a1+'/'+$scope.g1+'/'+$scope.p1+'/'+$scope.c2+'/'+$scope.a2+'/'+$scope.g2+'/'+$scope.p2+'/'+$scope.winner+'/'+$scope.locale+'/'+$scope.vers);
		}
	}
	$scope.loadLatest = function() {
		$http.post('latest.php', {}).success(function(data, status, headers, config) {
			//		console.log(data);
					$rootScope.dbresults = data;
				 });
		//should there be a reset of vars here?
		$scope.changeURL();
	}
	$scope.resetFilters = function() {
		$scope.c1 = 'any';
		$scope.c2 = 'any';
		$scope.a1 = 'any';
		$scope.a2 = 'any';
		$scope.g1 = '0';
		$scope.g2 = '0';
		$scope.p1 = '';
		$scope.p2 = '';
		$scope.winner = '0';
		$scope.locale = 'any';
		$scope.vers = '1';
	}
	
});