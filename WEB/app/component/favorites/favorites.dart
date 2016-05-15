import 'package:angular2/core.dart';
import 'package:angular2/router.dart';

@Component(
    selector: 'in-tuition-favorites',
    templateUrl: 'favorites.html',
    styleUrls: const ['favorites.css'],
    directives: const [],
    providers: const []
)

class FavoritesComponent{
  final Router _router;

  FavoritesComponent(this._router);
}