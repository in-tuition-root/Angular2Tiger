/**
 * Created by praghav on 5/14/2016.
 */

import {Injectable} from '@angular/core';
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import 'rxjs/Rx';
import {Headers} from "@angular/http";

@Injectable()
export class HttpService {
    constructor(private _http: Http) {}

    getPosts(): Observable<any> {
        return this._http.get('http://jsonplaceholder.typicode.com/posts').map(res => res.json());
        /**
        let headers = new Headers();
        headers.append('Content-Type', 'application/x-www-urlencoded');
        return this._http.get('http://10.41.120.171:81/tutorUtils/tutavailability',{headers: headers}).map(res => res.json());
         **/
    }

    createPost(post: {title: string, body: string, userId: number}): Observable<any> {
        const body = JSON.stringify(post);
        let headers = new Headers();
        headers.append('Content-Type', 'application/x-www-urlencoded');
        return this._http.post('http://jsonplaceholder.typicode.com/posts', body, {
            headers: headers
        }).map(res => res.json());
    }
}