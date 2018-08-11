<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns:tei="http://www.tei-c.org/ns/1.0"
                xmlns:xs="http://www.w3.org/2001/XMLSchema"
                xmlns:exslt="http://exslt.org/common"
                xmlns:php="http://php.net/xsl"
                exclude-result-prefixes="xs tei exslt php"
                version="1.0">

    <xsl:output method="html" encoding="UTF-8" indent="yes" xml:space="preserve" omit-xml-declaration="yes" />

    <!-- identity transform: copy source nodes to target document -->
    <xsl:template match="@* | node()">
        <xsl:copy>
            <xsl:apply-templates select="@* | node()"/>
        </xsl:copy>
    </xsl:template>

    <!-- headings -->
    <xsl:template match="ab[@rend]">
        <xsl:choose>
            <xsl:when test="@rend = 'h1'">
                <h1>
                    <xsl:apply-templates select="node()"/>
                </h1>
            </xsl:when>
            <xsl:when test="@rend = 'h2'">
                <h2>
                    <xsl:apply-templates select="node()"/>
                </h2>
            </xsl:when>
            <xsl:when test="@rend = 'h3'">
                <h3>
                    <xsl:apply-templates select="node()"/>
                </h3>
            </xsl:when>
            <xsl:when test="@rend = 'h4'">
                <h4>
                    <xsl:apply-templates select="node()"/>
                </h4>
            </xsl:when>
            <xsl:when test="@rend = 'h5'">
                <h5>
                    <xsl:apply-templates select="node()"/>
                </h5>
            </xsl:when>
            <xsl:when test="@rend = 'h6'">
                <h6>
                    <xsl:apply-templates select="node()"/>
                </h6>
            </xsl:when>
        </xsl:choose>
    </xsl:template>

    <!-- links -->
    <xsl:template match="ref">
        <xsl:choose>
            <xsl:when test="php:function('substring', @target, 1, 4) = 'http'">
                <a class="external" href="{@target}">
                    <xsl:apply-templates select="node()"/>
                </a>
            </xsl:when>
            <xsl:otherwise>
                <a href="{php:function('str_replace', '.xml', '.html', @target)}">
                    <xsl:apply-templates select="node()"/>
                </a>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>

    <!-- tables -->
    <xsl:template match="table">
        <table>
            <xsl:apply-templates select="node()"/>
        </table>
    </xsl:template>
    <xsl:template match="row">
        <tr>
            <xsl:apply-templates select="node()"/>
        </tr>
    </xsl:template>
    <xsl:template match="cell">
        <td>
            <xsl:apply-templates select="node()"/>
        </td>
    </xsl:template>

    <!-- images -->
    <xsl:template match="figure"/>

    <!-- linebreaks -->
    <xsl:template match="lb">
        <br/>
    </xsl:template>

    <!-- dates -->
    <xsl:template match="date">
        <time datetime="{@when}">
            <xsl:apply-templates select="node()"/>
        </time>
    </xsl:template>

    <!-- underlined text -->
    <xsl:template match="hi[@rend = 'underline']">
        <span class="underline">
            <xsl:apply-templates select="node()"/>
        </span>
    </xsl:template>

    <!-- twice underlined text-->
    <xsl:template match="hi[@rend = 'twice-underline']">
        <span class="twice-underline">
            <xsl:apply-templates select="node()"/>
        </span>
    </xsl:template>

    <!-- strike through text-->
    <xsl:template match="hi[@rend = 'line-through']">
        <del>
            <xsl:apply-templates select="node()"/>
        </del>
    </xsl:template>

    <!-- sup -->
    <xsl:template match="hi[@rend = 'super']">
        <sup class="sup">
            <xsl:apply-templates select="node()"/>
        </sup>
    </xsl:template>

    <!-- em -->
    <xsl:template match="emph[@rend = 'em']">
        <em>
            <xsl:apply-templates select="node()"/>
        </em>
    </xsl:template>

    <!-- strong -->
    <xsl:template match="emph[@rend = 'strong']">
        <strong>
            <xsl:apply-templates select="node()"/>
        </strong>
    </xsl:template>

    <!-- foreign language -->
    <xsl:template match="foreign">
        <i class="foreign">
            <xsl:apply-templates select="node()"/>
        </i>
    </xsl:template>

    <!-- div -->
    <xsl:template match="div">
        <xsl:choose>
            <xsl:when test="@n">
                <div class="{@n}">
                    <xsl:apply-templates select="node()"/>
                </div>
            </xsl:when>
            <xsl:otherwise>
                <div>
                    <xsl:apply-templates select="node()"/>
                </div>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>

    <!-- footnotes -->
    <xsl:template match="note">
        <xsl:variable name="count">
            <xsl:number level="any" count="note" from="text"/>
        </xsl:variable>
        <sup class="fn">
            <a href="#ap-{$count}" id="fn-{$count}">
                <xsl:value-of select="$count"/>
            </a>
        </sup>
    </xsl:template>

</xsl:stylesheet>