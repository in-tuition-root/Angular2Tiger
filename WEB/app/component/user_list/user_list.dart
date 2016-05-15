import 'dart:async';

import 'package:angular2/core.dart';
import 'package:angular2/router.dart';

//  Start of polymer elements
import 'package:polymer_elements/iron_flex_layout.dart';
import 'package:polymer_elements/iron_icons.dart';
import 'package:polymer_elements/iron_pages.dart';
import 'package:polymer_elements/iron_selector.dart';


import 'package:polymer_elements/paper_drawer_panel.dart';
import 'package:polymer_elements/paper_icon_button.dart';
import 'package:polymer_elements/paper_item.dart';
import 'package:polymer_elements/paper_material.dart';

import 'package:polymer_elements/paper_menu.dart';
import 'package:polymer_elements/paper_scroll_header_panel.dart';
import 'package:polymer_elements/paper_styles/classes/typography.dart';

import 'package:polymer_elements/paper_toast.dart';
import 'package:polymer_elements/paper_toolbar.dart';
import 'package:polymer_elements/paper_header_panel.dart';

import 'package:polymer_elements/paper_input.dart';
import 'package:polymer_elements/paper_card.dart';
import 'package:polymer_elements/paper_fab.dart';
//  End of polymer elements

import 'package:abc_tuition/service/user_service.dart';
import 'package:abc_tuition/model/user_model.dart';
import 'package:abc_tuition/component/user_details/user_details.dart';


@Component(
    selector: 'in-tuition-user-list',
    templateUrl: 'user_list.html',
    styleUrls: const ['user_list.css'],
    directives: const [ROUTER_DIRECTIVES,UserDetailComponent],
    providers: const [ROUTER_PROVIDERS,UserService]
)


class UserListComponent implements OnInit{
  final Router _router;
  final UserService _userService;

  List<UserModel> users;
  UserModel selectedUser;

  UserListComponent(this._userService,this._router);

  Future getUsers() async {
    users = await _userService.getUsers();
  }

  void ngOnInit() {
    getUsers();
  }

  void onSelect(UserModel user) { selectedUser = user; }

  Future gotoDetail() =>
      _router.navigate(['UserDetail', {'id': selectedUser.id.toString()}]);

}