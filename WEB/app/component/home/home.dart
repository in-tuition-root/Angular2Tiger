import 'package:angular2/core.dart';
import 'package:angular2/router.dart';
import 'package:abc_tuition/component/user_list/user_list.dart';

@Component(
    selector: 'in-tuition-home',
    templateUrl: 'home.html',
    styleUrls: const ['home.css'],
    directives: const [UserListComponent],
    providers: const []
)

class HomeComponent{
  final Router _router;

  HomeComponent(this._router);
}