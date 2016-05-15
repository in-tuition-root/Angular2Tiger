import {bootstrap}    from '@angular/platform-browser-dynamic';
import {enableProdMode, provide} from '@angular/core';
import {ROUTER_PROVIDERS} from '@angular/router';
import {HTTP_PROVIDERS} from "@angular/http";
import {LocationStrategy, HashLocationStrategy} from '@angular/common';
import {AppComponent} from './app.component';
import {AuthService} from "./service/AuthenticationService";

enableProdMode();
bootstrap(AppComponent, [
    ROUTER_PROVIDERS, HTTP_PROVIDERS, AuthService,
    provide(LocationStrategy, {useClass: HashLocationStrategy})
]);