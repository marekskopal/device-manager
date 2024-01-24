import {Injectable} from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { map } from 'rxjs/operators';

import { environment } from '@environments/environment';
import { Device } from '@app/models';
import {NotifyService} from "@app/services/notify-service";
import {Observable} from "rxjs";
import {OkResponse} from "@app/models/ok-response";

@Injectable({ providedIn: 'root' })
export class DeviceService extends NotifyService {
    public constructor(
        private http: HttpClient,
    ) {
        super();
    }

    public createDevice(broker: Device): Observable<Device> {
        return this.http.post<Device>(`${environment.apiUrl}/device`, broker);
    }

    public getDevices(): Observable<Device[]> {
        return this.http.get<Device[]>(`${environment.apiUrl}/device`);
    }

    public getDevice(id: number): Observable<Device> {
        return this.http.get<Device>(`${environment.apiUrl}/device/${id}`);
    }

    public updateDevice(id: number, broker: Device): Observable<Device> {
        return this.http.put<Device>(`${environment.apiUrl}/device/${id}`, broker)
            .pipe(map(x => {
                return x;
            }));
    }

    public deleteDevice(id: number): Observable<OkResponse> {
        return this.http.delete<OkResponse>(`${environment.apiUrl}/device/${id}`)
            .pipe(map(x => {
                return x;
            }));
    }
}
