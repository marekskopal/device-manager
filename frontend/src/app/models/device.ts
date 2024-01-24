import {AEntity} from "@app/models/AEntity";
import {Owner} from "@app/models/owner";

export class Device extends AEntity {
    public hostname: string;
    public type: DeviceTypeEnum;
    public os: OsEnum;
    public owner: Owner
}

export enum DeviceTypeEnum {
    Pc = 'pc',
    Laptop = 'laptop',
    Mobile = 'mobile',
}

export enum OsEnum {
    Windows = 'windows',
    Linux = 'linux',
    MacOS = 'macos',
    IOS = 'ios',
    Android = 'android',
}
