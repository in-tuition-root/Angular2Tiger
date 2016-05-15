import 'package:angular2/core.dart';

import 'package:abc_tuition/service/user_service.dart';
import 'package:abc_tuition/model/user_model.dart';
import 'package:angular2/router.dart';
import 'dart:html';

@Component(
    selector: 'in-tuition-user-detail',
    templateUrl: 'user_details.html',
    styleUrls: const ['user_details.css'],
    inputs: const ['user'])


class UserDetailComponent implements OnInit{
  UserModel user;
  // #enddocregion implement
  final UserService _userService;
  final RouteParams _routeParams;

  UserDetailComponent(this._userService, this._routeParams);
// #enddocregion ctor

// #docregion ng-oninit
  ngOnInit() async {
    // #docregion get-id
    var id = int.parse(_routeParams.get('id'));
    // #enddocregion get-id
    user = await (_userService.getUser(id));
  }
// #enddocregion ng-oninit

// #docregion go-back
  goBack() {
    window.history.back();
  }
}