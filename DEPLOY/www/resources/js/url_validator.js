
//////////////////////////////////////////////////////////////////
/// Copyright © 2017—2024 Maxim Rysevets. All rights reserved. ///
//////////////////////////////////////////////////////////////////

export default class URL_validator {

    constructor(url, options = {}) {
        this.hasError = true;
        if (options.protocols === undefined) options.protocols = 'http|https|ftp|ftps';
        if (options.unicode   === undefined) options.unicode   = '\\p{Ll}\\p{Lo}\\p{Lt}\\p{Lu}';
        this.pattern = new RegExp(`^(?:(${options.protocols})://|)`                                     + // protocol
                                      `([${options.unicode}a-zA-Z0-9\\-\\.]{2,200}(?::([0-9]{1,5})|)|)` + // domain + port
                                     `(/[${options.unicode}\\x21-\\x22\\x24-\\x3e\\x40-\\x7e]*|)`       + // path
                                `(?:\\?([${options.unicode}\\x21-\\x22\\x24-\\x7e]*)|)`                 + // query
                                  `(?:#([${options.unicode}\\x21-\\x7e]*)|)$`, 'u');                      // anchor
        this.parse = url.match(this.pattern)?.map((value) => value === undefined ? '' : value);
        let [, protocol, domain, port, path, query, anchor] = this.parse ?? [, '', '', '', '', '', '', ''];
        // matrix check
        if ( ( protocol.length && domain.length && !path.length && !query.length && !anchor.length) ||  // protocol://domain
             ( protocol.length && domain.length &&  path.length && !query.length && !anchor.length) ||  // protocol://domain/path
             ( protocol.length && domain.length &&  path.length &&  query.length && !anchor.length) ||  // protocol://domain/path?query
             ( protocol.length && domain.length &&  path.length && !query.length &&  anchor.length) ||  // protocol://domain/path?#anchor
             ( protocol.length && domain.length &&  path.length &&  query.length &&  anchor.length) ) { // protocol://domain/path?query#anchor
            this.hasError = false;
        }
    }

}
