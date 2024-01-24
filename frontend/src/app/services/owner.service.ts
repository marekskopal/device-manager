import {Injectable} from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { map } from 'rxjs/operators';

import { environment } from '@environments/environment';
import { Owner } from '@app/models';
import {NotifyService} from "@app/services/notify-service";
import {Observable} from "rxjs";
import {OkResponse} from "@app/models/ok-response";

@Injectable({ providedIn: 'root' })
export class OwnerService extends NotifyService {
    public constructor(
        private http: HttpClient,
    ) {
        super();
    }

    public createOwner(broker: Owner): Observable<Owner> {
        return this.http.post<Owner>(`${environment.apiUrl}/owner`, broker);
    }

    public getOwners(): Observable<Owner[]> {
        return this.http.get<Owner[]>(`${environment.apiUrl}/owner`);
    }

    public getOwner(id: number): Observable<Owner> {
        return this.http.get<Owner>(`${environment.apiUrl}/owner/${id}`);
    }

    public updateOwner(id: number, broker: Owner): Observable<Owner> {
        return this.http.put<Owner>(`${environment.apiUrl}/owner/${id}`, broker)
            .pipe(map(x => {
                return x;
            }));
    }

    public deleteOwner(id: number): Observable<OkResponse> {
        return this.http.delete<OkResponse>(`${environment.apiUrl}/owner/${id}`)
            .pipe(map(x => {
                return x;
            }));
    }
}
